<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="script-src * 'unsafe-inline' 'unsafe-eval';">      
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <!-- icons & styles -->        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/venobox@2.2.1/dist/venobox.min.css">    
    <link href="{{ asset('css/my_css.css') }}" rel="stylesheet">            
    @yield('in_head_css')
</head>

<body id="page-top" style="font-family:'Arial','Microsoft JhengHei','微軟正黑體','黑體',sans-serif;">

<br>
{{-- 主要內容區 --}}
<main id="main-content" class="container-fluid">    
    @yield('content')
</main>
<br>
<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/venobox@2.2.1/dist/venobox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/tinymce.js') }}"></script>
<script src="{{ asset('js/venobox.js') }}"></script>
<script src="{{ asset('js/sweet_alert.js') }}"></script>
<script src="{{ asset('js/my_js.js') }}"></script>
@yield('at_bottom_js')
</body>
</html>