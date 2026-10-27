@extends('layouts.master')

@section('nav_home_active', 'active')

@section('in_head_css')
    <link href="{{ asset('css/block_style.css') }}" rel="stylesheet">
@endsection

@section('top_image')    
    @if($setup->title_image)
        @if(!empty($photo_data))
            <?php $carousel_fade = ($setup->title_image_style == 2) ? "carousel-fade" : ""; ?>
            
            <style>
                .carousel-indicators button:focus,
                .carousel-indicators li:focus {
                    outline: 3px solid #ffc107 !important;
                    outline-offset: 3px;
                    box-shadow: 0 0 0 2px #000;
                }
            </style>

            <div id="carouselExampleIndicators" class="carousel slide {{ $carousel_fade }} position-relative" data-bs-ride="carousel" data-bs-pause="false" role="region" aria-label="焦點新聞輪播圖">
                
                <div id="carouselAnnouncer" class="visually-hidden" aria-live="polite" aria-atomic="true"></div>

                <div class="carousel-accessibility-control" style="position: absolute; top: 15px; right: 15px; z-index: 1050;">
                    <button type="button" id="carouselToggleBtn" class="btn btn-pause" aria-label="暫停輪播圖片" aria-pressed="false">
                        <i class="fas fa-pause me-1" aria-hidden="true"></i> <span>暫停輪播</span>
                    </button>
                </div>                

                <div class="carousel-indicators" role="tablist" aria-label="投影片分頁控制">
                    <?php $n=0; ?>
                    @foreach($photo_data as $k1 => $v1)
                        @if(is_iterable($v1))
                            @foreach($v1 as $k2 => $v2)
                                <?php 
                                    $active = ($n==0) ? "active" : ""; 
                                    $isSelected = ($n==0) ? "true" : "false";
                                ?>
                                <button type="button" 
                                    data-bs-target="#carouselExampleIndicators" 
                                    data-bs-slide-to="{{ $n }}" 
                                    class="{{ $active }}" 
                                    tabindex="0" 
                                    role="tab" 
                                    aria-selected="{{ $isSelected }}" 
                                    aria-label="切換至第 {{ $n + 1 }} 張投影片"></button>
                                <?php $n++; ?>
                            @endforeach
                        @endif
                    @endforeach
                </div>

                <div class="carousel-inner">
                    <?php $n=0; ?>
                    @foreach($photo_data as $k1 => $v1)
                        @if(is_iterable($v1))
                            @foreach($v1 as $k2 => $v2)
                                <?php 
                                    $active = ($n==0)?"active":""; 
                                    $img_alt = !empty($v2['title']) ? $v2['title'] : (!empty($v2['desc']) ? $v2['desc'] : '學生校園活動圖片 '.$k1);
                                ?>
                                <div class="carousel-item {{ $active }}">
                                    @if($v2['link'] != null)
                                        <a href="{{ $v2['link'] }}" target="_blank" title="{{ $img_alt }} (另開新視窗)">
                                            <img class="d-block w-100" src="{{ asset('storage/'.$school_code.'/title_image/random/'.$k2) }}" alt="{{ $img_alt }}">
                                        </a>
                                    @else
                                        <img class="d-block w-100" src="{{ asset('storage/'.$school_code.'/title_image/random/'.$k2) }}" alt="{{ $img_alt }}">
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        @if($v2['title'] != null)
                                            <p class="h3 fw-bold">{{ $v2['title'] }}</p>
                                        @endif
                                        @if($v2['desc'] != null)
                                            <p><strong>{{ $v2['desc'] }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                                <?php $n++; ?>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" aria-label="上一張投影片">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">上一張投影片</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" aria-label="下一張投影片">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">下一張投影片</span>
                </button>
            </div>
        @endif
    @endif
@endsection

@section('content')
    <h1 class="visually-hidden">{{ $setup->site_name }} - 首頁主要內容區</h1>    
    <?php $module_setup = get_module_setup(); ?>
    @if(isset($module_setup['校園跑馬燈']))
        <?php
            $school_marquee_width = (empty($setup->school_marquee_width))?"12":$setup->school_marquee_width;
            $school_marquee_color = (empty($setup->school_marquee_color))?"warning":$setup->school_marquee_color;
            $school_marquee_behavior = (empty($setup->school_marquee_behavior))?"scroll":$setup->school_marquee_behavior;
            $school_marquee_direction = (empty($setup->school_marquee_direction))?"up":$setup->school_marquee_direction;
            $school_marquee_scrollamount = (empty($setup->school_marquee_scrollamount))?"2":$setup->school_marquee_scrollamount;
        ?>
        @if($school_marquees->count()>0)
            <div class="row justify-content-center">
                <div class="col-lg-{{ $school_marquee_width }}">
                    <div class="alert alert-{{ $school_marquee_color }} p-1" style="margin-top: -15px; overflow: hidden;" role="region" aria-label="最新消息跑馬燈">
                        <div class="marquee-wrapper" id="marquee-container" tabindex="0"
                            style="height: 25px; overflow: hidden; position: relative; background: transparent;">                            
                            <div class="marquee-inner" id="marquee-content">
                                @foreach($school_marquees as $school_marquee)
                                    <span class="marquee-item" style="margin-right: 50px; display: inline-block;">
                                        <span aria-hidden="true">📣</span> {!! a11y_emoji($school_marquee->title) !!}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="row justify-content-center">
        @if(!empty($setup_cols) && is_iterable($setup_cols))
            @foreach($setup_cols as $setup_col)
                <div class="col-lg-{{ $setup_col->num }}">
                    @if(!empty($blocks[$setup_col->id]) && is_iterable($blocks[$setup_col->id]))
                        @foreach($blocks[$setup_col->id] as $block)
                            <?php
                                if(!is_null($block->block_color)){
                                    $block_color = explode(',',$block->block_color);
                                }else{
                                    $block_color[0] = "original-block";
                                    $block_color[1] = "original-title";
                                }
                                $rounded = ($block->disable_block_line == 1)?"rounded":null;
                            ?>

                            @if($block->title == "榮譽榜跑馬燈")                        
                                <div class="table-responsive">
                                    <div>                                
                                        @include('layouts.marquee')
                                    </div>
                                </div>
                            @else
                                @if($block->disable_block_line != 1)
                                    <div class="shadow rounded {{ $block_color[0] }}">
                                @endif
                                @if($block->block_position != "disable")
                                    <div class="{{ $block_color[1] }} {{$rounded }}">
                                        <?php
                                            $title = (empty($block->new_title))?$block->title:$block->new_title;
                                            $title=str_replace('(系統區塊)','',$title);
                                            $title=str_replace('_圖文版','',$title);
                                            $block_position = ($block->block_position==null)?"text-start":$block->block_position;
                                            if($block_position=="text-left") $block_position = "text-start";
                                            if($block_position=="text-right") $block_position = "text-end";
                                            if($block->block_position=="disable") $block_position = null;
                                        ?>
                                        <div class="{{ $block_position }}">
                                            @if($block_position) 
                                                {!! a11y_emoji($title) !!}
                                            @endif
                                            @auth
                                                @if(auth()->user()->admin==1)
                                                    <div class="float-end pe-2">
                                                        <a href="javascript:open_window('{{ route('setups.edit_block',$block->id) }}','新視窗')" title="編輯區塊：{{ $title }}" aria-label="編輯區塊：{{ $title }}">📝</a>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                @endif
                                <div class="content2" id="block{{ $block->id }}" style="margin-bottom: 5px;">
                                    <div class="table-responsive">
                                        @if($block->title == "最新公告(系統區塊)")
                                            @include('layouts.news')
                                        @elseif($block->title == "彰化空汙旗(系統區塊)")
                                            @include('layouts.chc_air')
                                        @elseif($block->title == "樹狀目錄(系統區塊)")
                                            @include('layouts.dtree')
                                        @elseif($block->title == "圖片連結(系統區塊)")
                                            @include('layouts.photo_link')
                                        @elseif($block->title == "分類公告(系統區塊)")
                                            @include('layouts.post_type')
                                        @elseif($block->title == "分類公告_圖文版(系統區塊)")
                                            @include('layouts.post_type2')
                                        @elseif($block->title == "校園部落格(系統區塊)")
                                            @include('layouts.blog')
                                        @elseif($block->title == "今日餐點1(系統區塊)")
                                            @include('layouts.lunch_today1')
                                        @elseif($block->title == "今日餐點2(系統區塊)")
                                            @include('layouts.lunch_today2')
                                        @elseif($block->title == "今日餐點3(系統區塊)")
                                            @include('layouts.lunch_today3')
                                        @elseif($block->title == "今日餐點4(系統區塊)")
                                            @include('layouts.lunch_today4')
                                        @elseif($block->title == "校務月曆(系統區塊)")
                                            @include('layouts.monthly_calendar')
                                        @elseif($block->title == "教室預約(系統區塊)")
                                            @include('layouts.classroom_order')
                                        @elseif($block->title == "RSS訊息(系統區塊)")
                                            @include('layouts.rss_feed')                           
                                        @elseif($block->title == "借用狀態(系統區塊)")
                                            @include('layouts.lend_list')
                                        @elseif($block->title == "常駐公告(系統區塊)")
                                            @include('layouts.inbox_posts')
                                        @elseif($block->title == "待修通報(系統區塊)")
                                            @include('layouts.fix')
                                        @elseif($block->title == "搜尋本站(系統區塊)")
                                            @include('layouts.search_site')
                                        @else
                                            {!! $block->content !!}
                                        @endif
                                    </div>
                                </div>
                                @if($block->disable_block_line != 1)
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=900,height=800');
        }

        /* 無障礙控制：輪播圖暫停 / 播放 & 分頁點鍵盤操作控制器 (Bootstrap 5) */
        document.addEventListener("DOMContentLoaded", function() {
            var carouselEl = document.getElementById('carouselExampleIndicators');
            var toggleBtn = document.getElementById('carouselToggleBtn');
            var announcer = document.getElementById('carouselAnnouncer');
            var isPaused = false;

            if (carouselEl) {
                var bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

                // 1. 鍵盤 Enter (13) 或 Space (32) 切換分頁
                carouselEl.querySelectorAll('.carousel-indicators button, .carousel-indicators li').forEach(function(indicator) {
                    indicator.addEventListener('keydown', function(e) {
                        if (e.which === 13 || e.which === 32) {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });

                // 2. 輪播狀態同步與語音報讀
                carouselEl.addEventListener('slid.bs.carousel', function (e) {
                    var indicators = carouselEl.querySelectorAll('.carousel-indicators button, .carousel-indicators li');
                    indicators.forEach(function(ind) { ind.setAttribute('aria-selected', 'false'); });
                    if (indicators[e.to]) {
                        indicators[e.to].setAttribute('aria-selected', 'true');
                    }

                    var activeItem = e.relatedTarget;
                    var img = activeItem ? activeItem.querySelector('img') : null;
                    var imgAlt = img ? (img.getAttribute('alt') || '') : '';
                    var currentIndex = e.to + 1;
                    var totalSlides = indicators.length;

                    if (announcer) {
                        announcer.textContent = '已切換至第 ' + currentIndex + ' 張投影片（共 ' + totalSlides + ' 張）：' + imgAlt;
                    }
                });

                if (toggleBtn) {
                    ['touchstart', 'touchend', 'touchmove', 'click'].forEach(function(evt) {
                        toggleBtn.addEventListener(evt, function(e) { e.stopPropagation(); });
                    });

                    toggleBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        if (!isPaused) {
                            isPaused = true;
                            bsCarousel.pause();
                            this.setAttribute('aria-pressed', 'true');
                            this.setAttribute('aria-label', '播放輪播圖片');
                            this.innerHTML = '<i class="fas fa-play me-1" aria-hidden="true"></i> <span>播放輪播</span>';
                        } else {
                            isPaused = false;
                            bsCarousel.cycle();
                            this.setAttribute('aria-pressed', 'false');
                            this.setAttribute('aria-label', '暫停輪播圖片');
                            this.innerHTML = '<i class="fas fa-pause me-1" aria-hidden="true"></i> <span>暫停輪播</span>';
                        }
                    });

                    carouselEl.addEventListener('slide.bs.carousel', function () {
                        if (isPaused) { bsCarousel.pause(); }
                    });

                    carouselEl.addEventListener('focusin', function() {
                        if (!isPaused) { bsCarousel.pause(); }
                    });
                    carouselEl.addEventListener('focusout', function() {
                        if (!isPaused) { bsCarousel.cycle(); }
                    });
                }
            }
        });
    </script>
@endsection

@section('footer')
    @if(!empty($setup->footer))
        <footer class="font-small py-4" id="footer" tabindex="-1" role="contentinfo" aria-label="頁尾資訊區">
            <div class="container-fluid text-center text-md-start">
                <div class="row justify-content-center">
                    <div class="col-md-11">                            
                        @auth
                            @if(auth()->user()->admin==1)  
                                <div class="float-end">
                                    <a href="javascript:open_window('{{ route('setups.edit_footer') }}','新視窗')" title="編輯頁尾內容" aria-label="編輯頁尾內容">📝</a>
                                </div>
                            @endif
                        @endauth
                        {!! $setup->footer !!}
                    </div>
                </div>
            </div>
        </footer>
    @endif
    @if($setup->disable_right==null)
<div class="footer-copyright text-center py-3 bg-dark text-white border-top border-secondary" id="footer_bottom">
    <div class="container-fluid px-3">
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
            
            <div class="fw-semibold small">
                &copy; {{ date('Y') }} 
                <a href="{{ route('index','index') }}" class="text-white fw-bold text-decoration-underline">
                    {{ $setup->site_name }}
                </a> 
                <span class="mx-1">All Rights Reserved.</span>
            </div>

            <span class="d-none d-md-inline opacity-50" aria-hidden="true">|</span>

            <div class="d-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill border border-secondary text-white">
                <i class="fas fa-chart-line text-warning me-2" aria-hidden="true"></i>
                <span class="small fw-bold">訪客人次：</span>
                <span class="fw-bold">{{ number_format($setup->views) }}</span>
            </div>

            <div class="d-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill border border-secondary text-white">
                <i class="fas fa-network-wired text-info me-2" aria-hidden="true"></i>
                <span class="small fw-bold">您的 IP：</span>
                <span class="fw-bold">{{ GetIP() }}</span>
            </div>

        </div>
    </div>
</div>                   
    @endif

    <?php $admin = \App\Models\User::where('username','admin')->first(); ?>
    @auth
        @if(auth()->user()->admin==1)
            @if($admin && Hash::check('demo1234', $admin->password))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var modalEl = document.getElementById('myModal');
                    if (modalEl) {
                        var myModal = new bootstrap.Modal(modalEl);
                        myModal.show();
                    }
                });
            </script>
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-danger" id="myModalLabel">嚴重資安危險!</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="關閉對話視窗"></button>
                    </div>
                    <div class="modal-body">
                        請你立即變更本機帳號 admin 的密碼，不得使用預設密碼。若未變更而發生資安事件，貴校須負相關責任！
                        <br>步驟為：
                        <br>1.本機登入 admin 帳號
                        <br>2.右上角 <i class="fas fa-user" aria-hidden="true"></i> 符號按一下，選擇「更改密碼」
                        <br>3.輸入舊密碼，與兩次新密碼，「送出」完成變更。
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">我知道了</button>
                    </div>
                  </div>
                </div>
            </div>
            @endif
        @endif
    @endauth    
@endsection

@if(isset($module_setup['校園跑馬燈']))
    @if(!empty($school_marquees) && $school_marquees->count()>0)
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const behavior = "{{ $school_marquee_behavior }}";     
            const direction = "{{ $school_marquee_direction }}";   
            const amount = parseInt("{{ $school_marquee_scrollamount }}") || 6;

            const container = document.getElementById('marquee-container');
            const content = document.getElementById('marquee-content');

            if (container && content) {
                content.style.position = 'absolute';
                content.style.display = 'flex';
                content.style.whiteSpace = 'nowrap';
                
                if (direction === 'up' || direction === 'down') {
                    content.style.flexDirection = 'column';
                }

                const contentWidth = content.offsetWidth;
                const containerWidth = container.offsetWidth;
                const contentHeight = content.offsetHeight;
                const containerHeight = container.offsetHeight;

                let keyframes = '';
                if (direction === 'left') {
                    keyframes = `@keyframes marqueeMove { 
                        0% { transform: translateX(${containerWidth}px); } 
                        100% { transform: translateX(-${contentWidth}px); } 
                    }`;
                } else if (direction === 'right') {
                    keyframes = `@keyframes marqueeMove { 
                        0% { transform: translateX(-${contentWidth}px); } 
                        100% { transform: translateX(${containerWidth}px); } 
                    }`;
                } else if (direction === 'up') {
                    keyframes = `@keyframes marqueeMove { 
                        0% { transform: translateY(${containerHeight}px); } 
                        100% { transform: translateY(-${contentHeight}px); } 
                    }`;
                } else if (direction === 'down') {
                    keyframes = `@keyframes marqueeMove { 
                        0% { transform: translateY(-${contentHeight}px); } 
                        100% { transform: translateY(${containerHeight}px); } 
                    }`;
                }

                const style = document.createElement('style');
                style.innerHTML = keyframes;
                document.head.appendChild(style);

                const duration = (direction === 'left' || direction === 'right') 
                                ? (contentWidth + containerWidth) / (amount * 10) 
                                : (contentHeight + containerHeight) / (amount * 5);

                content.style.animation = `marqueeMove ${duration}s linear infinite`;

                if (behavior === 'slide') {
                    content.style.animationIterationCount = '1';
                    content.style.animationFillMode = 'forwards';
                } else if (behavior === 'alternate') {
                    content.style.animationDirection = 'alternate';
                }

                container.onmouseover = () => content.style.animationPlayState = 'paused';
                container.onmouseout = () => content.style.animationPlayState = 'running';
                container.onfocusin = () => content.style.animationPlayState = 'paused';
                container.onfocusout = () => content.style.animationPlayState = 'running';
            }
        });
        </script>
    @endif
@endif