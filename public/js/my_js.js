document.addEventListener("DOMContentLoaded", function() {

    /* =========================================================
       全域 AccessKey 無障礙快捷鍵與焦點精準定位
       ========================================================= */

    // 中央主要內容區 (Alt + C)
    $(document).on('click', 'a[href="#main-content"], a[href="#main-content-target"], a[accesskey="C"]', function(e) {
        e.preventDefault();
        var $target = $('#main-content-target');
        if (!$target.length) {
            $target = $('#main-content');
        }
        if ($target.length) {
            $target.focus();
            $('html, body').animate({
                scrollTop: $target.offset().top - 15
            }, 100);
        }
    });

    // 下方底部資訊區 (Alt + Z)
    $(document).on('click', 'a[href="#footer"], a[accesskey="Z"]', function(e) {
        e.preventDefault();
        var $footer = $('#footer');
        if (!$footer.length) {
            $footer = $('footer').first();
        }
        if ($footer.length) {
            $footer.attr('tabindex', '-1').focus();
            $('html, body').animate({
                scrollTop: $footer.offset().top - 20
            }, 100);
        }
    });

    if (window.innerWidth >= 992) {
        var dropdownEls = document.querySelectorAll('#mainNav .dropdown');

        dropdownEls.forEach(function(dd) {
            // 滑鼠移入：開啟當前選單，並強制關閉其他所有已開啟的選單
            dd.addEventListener('mouseenter', function() {
                dropdownEls.forEach(function(other) {
                    if (other !== dd) {
                        var otherToggle = other.querySelector('[data-bs-toggle="dropdown"]');
                        if (otherToggle) {
                            var instance = bootstrap.Dropdown.getInstance(otherToggle);
                            if (instance) instance.hide();
                            otherToggle.classList.remove('show');
                            var otherMenu = other.querySelector('.dropdown-menu');
                            if (otherMenu) otherMenu.classList.remove('show');
                        }
                    }
                });

                var toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
                if (toggle) {
                    var bsDropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);
                    bsDropdown.show();
                }
            });

            // 滑鼠移出：隱藏當前選單
            dd.addEventListener('mouseleave', function() {
                var toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
                if (toggle) {
                    var bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                    if (bsDropdown) bsDropdown.hide();
                }
            });
        });
    }

});
