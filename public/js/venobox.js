/* 無障礙 2.1.2 核心修正：VenoBox 燈箱全鍵盤控制與 Focus Trap 鎖定 */
var triggerElement = null;
var lightboxKeyHandler = null;
var isReloading = false; // 防鎖死旗標：確保只執行一次 reload

// ⚡ 執行父頁面重整的核心函式
function triggerParentReload() {
    if (!isReloading) {
        isReloading = true;
        window.location.reload();
    }
}

var vb = new VenoBox({
    selector: '.venobox',
    numeration: true,
    infinigall: true,
    spinner: 'rotating-plane',
    maxWidth: '100%',
    maxHeight: '90%',
    onPostOpen: function(content, obj, gallIndex, then) {
        isReloading = false; // 每次開啟燈箱時重置狀態
        triggerElement = document.activeElement;

        setTimeout(function() {
            var overlay = document.querySelector('.vbox-overlay');
            if (!overlay) return;

            // 若內容為 iframe，優先將焦點移至 iframe 內部
            var iframe = overlay.querySelector('.vbox-content iframe');
            if (iframe) {
                iframe.focus();
            }

            // 動態強制修復並取得當前畫面上所有可見的可聚焦按鈕
            function getFocusables() {
                var allControls = overlay.querySelectorAll('.vbox-close, .vbox-prev, .vbox-next, .vbox-left, .vbox-right');
                
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

            var focusables = getFocusables();
            if (!iframe && focusables.length > 0) {
                focusables[0].focus();
            }

            // 一體化鍵盤控制
            lightboxKeyHandler = function(e) {
                var currentOverlay = document.querySelector('.vbox-overlay');
                if (!currentOverlay || !document.body.contains(currentOverlay)) return;

                var key = e.key;
                var keyCode = e.keyCode;
                var activeEl = document.activeElement;

                if (key === 'Tab' || keyCode === 9) {
                    var items = getFocusables();
                    if (items.length === 0) return;

                    var firstItem = items[0];
                    var lastItem = items[items.length - 1];

                    if (e.shiftKey) {
                        if (activeEl === firstItem || !currentOverlay.contains(activeEl)) {
                            e.preventDefault();
                            lastItem.focus();
                        }
                    } else {
                        if (activeEl === lastItem || !currentOverlay.contains(activeEl)) {
                            e.preventDefault();
                            firstItem.focus();
                        }
                    }
                }
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
                else if (key === 'Escape' || keyCode === 27) {
                    e.preventDefault();
                    vb.close();
                }
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

    // ⚡ VenoBox 2 修復關鍵：使用 onPreClose 確保點擊關閉/黑框時 100% 同步觸發重整
    onPreClose: function() {
        if (lightboxKeyHandler) {
            document.removeEventListener('keydown', lightboxKeyHandler);
            lightboxKeyHandler = null;
        }
        triggerParentReload();
    },
    
    // 備用防線
    onPostClose: function() {
        triggerParentReload();
    }
});

/* 原生關閉按鈕雙重保障 */
$(document).on('click', '.vbox-close', function() {
    triggerParentReload();
    vb.close();
});

/* 點擊黑框背景強效保險 */
$(document).on('click', '.vbox-overlay', function(e) {
    if ($(e.target).hasClass('vbox-overlay') || $(e.target).hasClass('vbox-container')) {
        triggerParentReload();
    }
});

/* iframe 內部關閉按鈕跨視窗呼叫機制 */
$(document).on('click', '#closeVeno', function(e) {
    e.preventDefault();
    
    // 若在 iframe 內部，直接讓頂層視窗 reload
    if (window.self !== window.top) {
        window.top.location.reload();
        return;
    }

    triggerParentReload();
    if ($('.vbox-close').length > 0) {
        $('.vbox-close').trigger('click');
    }
});