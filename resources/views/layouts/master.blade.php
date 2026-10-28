<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
    <?php
        $school_code = school_code();$setup = \App\Models\Setup::first();

        $setup_key = "setup".$school_code;
        if(!session($setup_key)){
            $att['views'] =$setup->views+1;
            $setup->update($att);
        }
        session([$setup_key => '1']);

        $nav_color = (empty($setup->nav_color))?"navbar-dark bg-dark":"navbar-custom";
        $bg_color = (empty($setup->bg_color))?"#f0f1f6":$setup->bg_color;
        $navbar_custom = (empty($setup->nav_color))?['0'=>'','1'=>'','2'=>'','3'=>'']:explode(",",$setup->nav_color);
    ?>
    @if(file_exists(storage_path('app/public/'.$school_code.'/title_image/logo.ico')))
        <link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('storage/'.$school_code.'/title_image/logo.ico') }}" />
    @else
        <link rel="Shortcut Icon" type="image/x-icon" href="{{ asset('images/site_logo.png') }}" />
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $setup->site_name }}全球資訊網">
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="script-src * 'unsafe-inline' 'unsafe-eval';">
    <title>@yield('title'){{ $setup->site_name }}</title>    
    <!-- jQuery-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_zh_TW.min.js"></script>
    <!-- icons & styles -->        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-iconpicker@3.2.0/dist/css/fontawesome-iconpicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/venobox@2.2.1/dist/venobox.min.css">        
    <link href="{{ asset('css/my_css.css') }}" rel="stylesheet">
    @if($setup->fixed_nav)
        <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
    @endif
    
    <style>
        /* 動態導覽欄顏色 (來自後台設定，需保留於 Blade 內) */
        .navbar-custom {
            background-color: {{ $navbar_custom[0] }};
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: {{ $navbar_custom[1] }};
        }
        .navbar-custom .navbar-nav .nav-link {
            color: {{ $navbar_custom[2] }};
        }
        .navbar-custom .nav-item.active .nav-link,
        .navbar-custom .nav-item:hover .nav-link {
            color: {{ isset($navbar_custom[3]) ?$navbar_custom[3] : '' }};
        }

        /* =========================================================
           無障礙 2.4.7 焦點可視 (Focus Visible) 完整四邊橘框修正
           ========================================================= */
        
        /* 1. 「跳過導覽連結」焦點獲得時顯眼彈出樣式 */
        .visually-hidden-focusable:focus {
            position: absolute !important;
            top: 10px !important;
            left: 10px !important;
            z-index: 999999 !important;
            width: auto !important;
            height: auto !important;
            padding: 10px 18px !important;
            margin: 0 !important;
            overflow: visible !important;
            clip: auto !important;
            white-space: normal !important;
            background-color: #0d47a1 !important; /* 高對比深藍背景 */
            color: #ffffff !important;            /* 純白文字 */
            font-weight: bold !important;
            font-size: 1.1rem !important;
            border: 2px solid #ffffff !important;
            border-radius: 6px !important;
            outline: 4px solid #d97706 !important;
            outline-offset: -2px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
            text-decoration: none !important;
        }

        /* 2. Alt+C 主要內容區獲得焦點時呈現顯眼橘框標示 */
        #main-content-target:focus {
            position: relative !important;
            display: inline-block !important;
            width: auto !important;
            height: auto !important;
            padding: 4px 10px !important;
            margin-bottom: 8px !important;
            overflow: visible !important;
            clip: auto !important;
            background-color: #0d47a1 !important;
            color: #ffffff !important;
            font-weight: bold !important;
            border-radius: 4px !important;
            outline: 3px solid #d97706 !important;
            outline-offset: 2px !important;
            text-decoration: none !important;
        }

        /* 3. 全站所有聚焦元素呈現完整四邊高對比橘色焦點框 */
        :focus,
        :focus-visible {
            outline: 3px solid #d97706 !important;
            outline-offset: -3px !important;
            box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.3) !important;
        }
    </style>
    @yield('in_head_css')
</head>

<body id="page-top" style="background-color:{{ $bg_color }};font-family:'Arial','Microsoft JhengHei','微軟正黑體','黑體',sans-serif;">

<!-- 無障礙 2.4.1 關鍵修正：跳到主要內容 -->
<a class="visually-hidden-focusable" href="#main-content-target" accesskey="C" title="主要內容區 (Alt+C)">跳到主要內容</a>

{{-- 僅在當前頁面有宣告 footer 區塊時，才渲染 Alt+Z 連結 --}}
@hasSection('footer')
<a class="visually-hidden-focusable" href="#footer" accesskey="Z" title="底部資訊區 (Alt+Z)">跳到底部資訊區</a>
@endif

{{-- 上方導覽區 --}}
<div id="navbar-container">
    @include('layouts.nav')
</div>

@yield('top_image')

<br>
{{-- 主要內容區 --}}
<main id="main-content" class="container-fluid">
    <!-- 無障礙 Alt+C 定位點 -->
    <a id="main-content-target" tabindex="-1" class="visually-hidden">::: 主要內容區</a>
    @yield('content')
</main>
<br>
<br>

{{-- 下方底部資訊區 --}}
<div>
    @yield('footer')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/venobox@2.2.1/dist/venobox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fontawesome-iconpicker@3.2.0/dist/js/fontawesome-iconpicker.min.js"></script>
<script src="{{ asset('js/venobox.js') }}"></script>
<script src="{{ asset('js/sweet_alert.js') }}"></script>
<script src="{{ asset('js/my_js.js') }}"></script>
@yield('at_bottom_js')
</body>
</html>