/* 無障礙 2.1.2 核心修正：VenoBox 燈箱全鍵盤控制與 Focus Trap 鎖定 */
var triggerElement = null;
var lightboxKeyHandler = null;

var vb = new VenoBox({
    selector: '.venobox',
    numeration: true,
    infinigall: true,
    spinner: 'rotating-plane',
    maxWidth: '100%',
    maxHeight: '90%',
    onPostOpen: function(content, obj, gallIndex, then) {
        // 1. 記錄開啟前的觸發元件，供關閉時歸還焦點
        triggerElement = document.activeElement;

        setTimeout(function() {
            var overlay = document.querySelector('.vbox-overlay');
            if (!overlay) return;

            // 2. 若內容為 iframe，優先將焦點移至 iframe 內部
            var iframe = overlay.querySelector('.vbox-content iframe');
            if (iframe) {
                iframe.focus();
            }

            // 3. 動態強制修復並取得當前畫面上所有可見的可聚焦按鈕
            function getFocusables() {
                var allControls = overlay.querySelectorAll('.vbox-close, .vbox-prev, .vbox-next, .vbox-left, .vbox-right');
                
                // 強制為 DOM 內部所有控制按鈕補上 Focus 關鍵屬性與 ARIA 標籤
                allControls.forEach(function(el) {
                    el.setAttribute('tabindex', '0');
                    el.setAttribute('role', 'button');
                    if (el.classList.contains('vbox-close')) {
                        el.setAttribute('aria-label', '關閉懸浮視窗');
                        el.setAttribute('title', '關閉懸浮視窗');
                    } else if (el.classList.contains('vbox-prev') || el.classList.contains('vbox-left')) {
                        el.setAttribute('aria-label', '檢視上一張照片');
                        el.setAttribute('title', '檢視上一張照片');
                    } else if (el.classList.contains('vbox-next') || el.classList.contains('vbox-right')) {
                        el.setAttribute('aria-label', '檢視下一張照片');
                        el.setAttribute('title', '檢視下一張照片');
                    }
                });

                // 依 HTML DOM 順序選取潛在焦點
                var candidates = overlay.querySelectorAll('.vbox-close, .vbox-next, .vbox-prev, .vbox-left, .vbox-right, a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])');
                
                return Array.from(candidates).filter(function(el) {
                    var style = window.getComputedStyle(el);
                    return el.offsetWidth > 0 && 
                           el.offsetHeight > 0 && 
                           style.display !== 'none' && 
                           style.visibility !== 'hidden' && 
                           style.opacity !== '0';
                });
            }

            // 4. 若非 iframe 頁面，預設將焦點定在第一個可聚焦按鈕（關閉按鈕）
            var focusables = getFocusables();
            if (!iframe && focusables.length > 0) {
                focusables[0].focus();
            }

            // 5. 一體化鍵盤控制（包含 Tab 鎖定循環、Enter/Space 觸發、Esc 關閉、左右方向鍵）
            lightboxKeyHandler = function(e) {
                var currentOverlay = document.querySelector('.vbox-overlay');
                if (!currentOverlay || !document.body.contains(currentOverlay)) return;

                var key = e.key;
                var keyCode = e.keyCode;
                var activeEl = document.activeElement;

                // A. Tab 鍵 Focus Trap (嚴格依據 DOM 順序於燈箱內部循環)
                if (key === 'Tab' || keyCode === 9) {
                    var items = getFocusables();
                    if (items.length === 0) return;

                    var firstItem = items[0];
                    var lastItem = items[items.length - 1];

                    if (e.shiftKey) { // Shift + Tab (反向移動)
                        if (activeEl === firstItem || !currentOverlay.contains(activeEl)) {
                            e.preventDefault();
                            lastItem.focus();
                        }
                    } else { // Tab (正向移動)
                        if (activeEl === lastItem || !currentOverlay.contains(activeEl)) {
                            e.preventDefault();
                            firstItem.focus();
                        }
                    }
                }

                // B. Enter (13) 或 Space (32) 鍵觸發對應動作，並維持焦點不掉落
                else if (key === 'Enter' || key === ' ' || keyCode === 13 || keyCode === 32) {
                    if (activeEl) {
                        if (activeEl.classList.contains('vbox-close') || activeEl.closest('.vbox-close')) {
                            e.preventDefault();
                            vb.close();
                        } else if (activeEl.classList.contains('vbox-prev') || activeEl.classList.contains('vbox-left') || activeEl.closest('.vbox-prev, .vbox-left')) {
                            e.preventDefault();
                            vb.prev();
                            setTimeout(function() {
                                var p = document.querySelector('.vbox-prev, .vbox-left');
                                if (p) p.focus();
                            }, 80);
                        } else if (activeEl.classList.contains('vbox-next') || activeEl.classList.contains('vbox-right') || activeEl.closest('.vbox-next, .vbox-right')) {
                            e.preventDefault();
                            vb.next();
                            setTimeout(function() {
                                var n = document.querySelector('.vbox-next, .vbox-right');
                                if (n) n.focus();
                            }, 80);
                        }
                    }
                }

                // C. Escape (27) 關閉懸浮視窗
                else if (key === 'Escape' || keyCode === 27) {
                    e.preventDefault();
                    vb.close();
                }

                // D. 左右方向鍵 (← / →) 直接切換照片
                else if (key === 'ArrowLeft' || keyCode === 37) {
                    e.preventDefault();
                    vb.prev();
                    setTimeout(function() {
                        var p = document.querySelector('.vbox-prev, .vbox-left');
                        if (p) p.focus();
                    }, 80);
                } else if (key === 'ArrowRight' || keyCode === 39) {
                    e.preventDefault();
                    vb.next();
                    setTimeout(function() {
                        var n = document.querySelector('.vbox-next, .vbox-right');
                        if (n) n.focus();
                    }, 80);
                }
            };

            document.addEventListener('keydown', lightboxKeyHandler);
        }, 100);
    },
    onPostClose: function() {
        // 6. 關閉燈箱時解除鍵盤監聽，並將焦點歸還給原本點擊的觸發元件
        if (lightboxKeyHandler) {
            document.removeEventListener('keydown', lightboxKeyHandler);
            lightboxKeyHandler = null;
        }
        if (triggerElement && typeof triggerElement.focus === 'function') {
            triggerElement.focus();
        }
    }
});

/* 原生關閉按鈕事件監聽 */
$(document).on('click', '.vbox-close', function() {
    vb.close();
});

/* iframe 內部關閉按鈕跨視窗呼叫機制 */
$(document).on('click', '#closeVeno', function(e) {
    e.preventDefault();
    
    // 檢查目前是否處於 iframe 內嵌狀態
    if (window.self !== window.top) {
        // 策略 1：模擬點擊父視窗（外層網頁）中 VenoBox 的原生關閉按鈕
        var parentCloseBtn = window.parent.document.querySelector('.vbox-close');
        if (parentCloseBtn) {
            parentCloseBtn.click();
            return;
        }
        
        // 策略 2：如果找不到關閉鈕，直接呼叫父視窗全域的 vb 物件關閉法
        if (window.parent.vb && typeof window.parent.vb.close === 'function') {
            window.parent.vb.close();
            return;
        }
    }

    // 備用防禦：如果這頁不是被當成 iframe，而是單獨開啟時，用來關閉自己內文點開的照片燈箱
    if ($('.vbox-close').length > 0) {
        $('.vbox-close').trigger('click');
    }
});