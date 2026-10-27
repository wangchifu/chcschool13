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

});
