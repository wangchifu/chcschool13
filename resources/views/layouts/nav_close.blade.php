<?php $module_setup = get_module_setup(); ?>
<?php        
    $fixed_top = ($setup->fixed_nav)?"fixed-top ":null;
?>

<!-- 全局手機端導覽列排版修補 -->
<style>
    @media (max-width: 991.98px) {
        .navbar {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0.5rem 0.75rem !important;
        }

        .navbar-brand {
            font-size: 1.05rem !important;
            font-weight: bold;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: calc(100% - 60px) !important;
            margin-right: 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        .navbar-brand img {
            width: 30px !important;
            height: 30px !important;
            margin-right: 6px !important;
            flex-shrink: 0;
        }

        .navbar-toggler {
            padding: 5px 10px !important;
            font-size: 1.25rem !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            border-radius: 6px !important;
            color: inherit !important;
            box-shadow: none !important;
            outline: none !important;
            flex-shrink: 0 !important;
        }

        .navbar-toggler:focus, .navbar-toggler:hover {
            background-color: rgba(255, 255, 255, 0.35) !important;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5) !important;
        }
    }
</style>

@if($nav_color == 'navbar-custom' && isset($navbar_custom[0]))
<style>
    .navbar-custom {
        background-color: {{ $navbar_custom[0] }} !important;
        --nav-brand-color: {{ $navbar_custom[1] }};
        --nav-link-color: {{ $navbar_custom[2] }};
        --nav-hover-color: {{ $navbar_custom[3] }};
    }
</style>
@endif

<nav class="navbar navbar-expand-lg {{ $nav_color }} {{ $fixed_top }}" id="mainNav" role="navigation" aria-label="主要選單導覽">
    <div class="container-fluid">        
        <a class="navbar-brand js-scroll-trigger d-inline-flex align-items-center" href="{{ route('index') }}" title="返回首頁 - {{ $setup->site_name }}">
            @if(file_exists(storage_path('app/public/'.$school_code.'/title_image/logo.ico')))
                <img src="{{ asset('storage/'.$school_code.'/title_image/logo.ico') }}" width="30" height="30" class="me-2" alt="{{ $setup->site_name }}標誌">
            @else
                <img src="{{ asset('images/site_logo.png') }}" width="30" height="30" class="me-2" alt="{{ $setup->site_name }}標誌">
            @endif
            <span style="white-space: nowrap;" aria-hidden="true">{{ $setup->site_name }}</span>
        </a>        
        
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="切換導覽選單顯示">
            <span class="navbar-toggler-icon" aria-hidden="true"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">                                                                      
            </ul>
        </div>
    </div>
</nav>