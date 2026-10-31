@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', $post->title.' | ')

@section('in_head')
    <!-- VenoBox CDN (CSS & JS) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.8/venobox.min.css" type="text/css" media="screen">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.8/venobox.min.js"></script>

    <style>
        /* 解決 Modal 被 z-index: 1080 的 Navbar 遮住的問題 */
        .modal {
            z-index: 1095 !important;
        }
        .modal-backdrop {
            z-index: 1090 !important;
        }
    </style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="row g-4">

            <!-- 主內容區塊 -->
            <div class="col-lg-8" role="region" aria-label="公告詳細內容">

                <?php
                if($post->insite==1){
                    if(auth()->check() or check_ip()){
                        $can_see = 1;
                    }else{
                        $can_see = 0;
                    }
                }else{
                    $can_see = 1;
                };
                //下架日比今天早(小)，不能看
                if($post->die_date != null and $post->die_date < date('Y-m-d')){
                    $can_see = 0;
                }
                //上架日比今天晚(大)，不能看
                if(substr($post->created_at,0,10) > date('Y-m-d')){
                    $can_see = 0;
                }
                //作者可以看
                if(auth()->check()){
                    if($post->user_id == auth()->user()->id){
                    $can_see = 1;
                    }
                }            
                ?>

                <!-- 麵包屑導覽列 -->
                <nav aria-label="麵包屑導覽" class="my-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none" title="返回首頁" aria-label="返回首頁">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none" title="返回公告列表" aria-label="返回公告列表">公告列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">公告內容</li>
                    </ol>
                </nav>

                <!-- 公告主標題 -->
                @if($can_see)
                    <h1 class="h2 my-3 fw-bold">{!! a11y_emoji($post->title) !!}</h1>                             
                @else
                    @if($post->insite==1 and ($post->die_date >= date('Y-m-d') or $post->die_date==null) and $post->created_at < date('Y-m-d H:i:s'))
                        <h1 class="h2 text-danger my-3 fw-bold">
                            <i class="fas fa-ban" aria-hidden="true"></i> [ 內部公告 ] {!! a11y_emoji($post->title) !!}
                        </h1>                                           
                    @endif
                    @if($post->die_date < date('Y-m-d') and $post->die_date != null)
                        <h1 class="h2 my-3 fw-bold">本公告已下架</h1>                
                    @elseif(substr($post->created_at,0,10) > date('Y-m-d'))
                        <h1 class="h2 my-3 fw-bold">本公告尚未上架</h1>
                    @endif
                @endif            

                <!-- 上一則 / 下一則切換導覽 -->
                <nav aria-label="前後公告切換" class="mb-3">
                    @if($last_id)
                        <a href="{{ route('posts.show',$last_id) }}" class="btn btn-secondary btn-sm" title="前往上一則公告" aria-label="前往上一則公告">
                            <i class="fas fa-arrow-alt-circle-left me-1" aria-hidden="true"></i> 上一則公告
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled aria-disabled="true">
                            <i class="fas fa-arrow-alt-circle-left me-1" aria-hidden="true"></i> 上一則公告
                        </button>
                    @endif

                    @if($next_id)
                        <a href="{{ route('posts.show',$next_id) }}" class="btn btn-secondary btn-sm ms-1" title="前往下一則公告" aria-label="前往下一則公告">
                            下一則公告 <i class="fas fa-arrow-alt-circle-right ms-1" aria-hidden="true"></i>
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm ms-1" disabled aria-disabled="true">
                            下一則公告 <i class="fas fa-arrow-alt-circle-right ms-1" aria-hidden="true"></i>
                        </button>
                    @endif
                </nav>

                <!-- 中間資訊與管理功能列 -->
                <div class="lead my-3" style="font-size: 1.1rem;">            
                    <?php
                        $insite = ($post->insite != null) ? $post->insite : 0;
                    ?>
                    <span class="me-3">類別：<a href="{{ route('posts.type',$insite) }}" class="text-decoration-none fw-bold" title="分類：{{ $post_type_array[$insite] }}" aria-label="分類：{{ $post_type_array[$insite] }}">{{ $post_type_array[$insite] }}</a></span>
                    <span class="me-3">張貼者：<a href="{{ route('posts.job_title',$post->job_title) }}" class="text-decoration-none text-secondary" title="張貼者：{{ $post->job_title }}" aria-label="張貼者：{{ $post->job_title }}">{{ $post->job_title }}</a></span>
                    @if($post->die_date)
                        <span class="me-3">張貼至：{{ $post->die_date }} 止</span>
                    @endif

                    @auth
                        @if(auth()->user()->admin)
                            @if($post->top)
                                @if(!empty($post->top_date))
                                    <span class="badge bg-secondary">置頂至 {{ $post->top_date }}</span>
                                @endif
                                <a href="#!" class="btn btn-warning btn-sm ms-1" onclick="sw_confirm1('確定要取消置頂？','{{ route('posts.top_down',$post->id) }}')" title="取消置頂" aria-label="取消置頂">
                                    <i class="fas fa-sort-amount-down me-1" aria-hidden="true"></i> 取消置頂
                                </a>
                            @else
                                <button type="button" class="btn btn-outline-success btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#exampleModal" title="設定置頂" aria-label="設定置頂">
                                    <i class="fas fa-sort-amount-up me-1" aria-hidden="true"></i> 置頂
                                </button>
                            @endif

                            @if($post->inbox)
                                <a href="#!" class="btn btn-secondary btn-sm ms-1" onclick="sw_confirm1('確定取消常駐公告？','{{ route('posts.inbox',$post->id) }}')" title="取消常駐公告" aria-label="取消常駐公告">
                                    <i class="fas fa-inbox me-1" aria-hidden="true"></i> 取消常駐
                                </a>
                            @else
                                <a href="{{ route('posts.inbox',$post->id) }}" class="btn btn-outline-warning btn-sm ms-1" title="放入常駐公告區塊" aria-label="放入常駐公告區塊">
                                    <i class="fas fa-inbox me-1" aria-hidden="true"></i> 常駐
                                </a>
                            @endif
                        @endif

                        @if(auth()->user()->id == $post->user_id or auth()->user()->admin == 1)
                            <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-outline-primary btn-sm ms-1" title="修改公告" aria-label="修改公告">
                                <i class="fas fa-edit me-1" aria-hidden="true"></i> 修改
                            </a>
                            <button type="button" class="btn btn-danger btn-sm ms-1" onclick="sw_confirm2('確定刪除？','delete_form')" title="刪除公告" aria-label="刪除公告">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> 刪除
                            </button>
                            
                            <!-- 替代 Form::open 的純 HTML 表單 -->
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" id="delete_form" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    @endauth
                </div>

                <hr>

                <!-- 張貼時間與點閱數 -->
                <p>
                    張貼日期： {{ $post->created_at }} 
                    點閱：
                    <a href="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/'.$post->id.'.txt') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="text-decoration-none"
                       title="查看點閱記錄檔：{{ $post->id }}.txt (副檔名：txt，另開新視窗)"
                       aria-label="查看點閱記錄檔：{{ $post->id }}.txt (副檔名：txt，另開新視窗)">
                        {{ $post->views }}
                        <span class="small text-muted">({{ $post->id }}.txt)</span>
                        <i class="fas fa-external-link-alt small me-1" aria-hidden="true"></i>
                        <span class="visually-hidden">(副檔名：txt，另開新視窗)</span>
                    </a>
                </p>

                <hr>

                <!-- 標題圖片 -->
                @if($can_see && !empty($post->title_image))                    
                    <img class="img-fluid rounded mb-3" src="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/title_image.png') }}" alt="{{ $post->title }} 的代表圖片">
                    <hr>                    
                @endif            

                <!-- 公告內文區塊 -->
                <article class="p-3 mb-4 rounded border bg-white" style="border-style: dotted !important; border-color: #939699 !important;" tabindex="0" aria-label="{{ $post->title }} 公告詳細內容區">
                    @if($can_see)
                        <div class="post-content-body">                                                                                                                                             
                            {!! sanitize_accessibility_html($post->content) !!}
                        </div>
                    @else
                        @if($post->insite==1 and ($post->die_date >= date('Y-m-d') or $post->die_date==null) and $post->created_at < date('Y-m-d H:i:s'))
                            <p class="text-danger fw-bold mb-0">
                                <i class="fas fa-lock me-1" aria-hidden="true"></i> [ 內部公告 ] 請登入後瀏覽！
                            </p>                                                                                              
                        @endif
                    @endif
                </article>

                <!-- 相關照片區塊 -->
                @if(!empty($photos) and $can_see)
                    <section class="card my-4 shadow-sm border" aria-label="相關照片區塊">
                        <h2 class="card-header bg-light h5 fw-bold py-3">相關照片</h2>
                        <div class="card-body">
                            <div class="row g-3">
                            @foreach($photos as $k => $v)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <a href="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/photos/'.$v) }}" class="venobox d-block" data-gall="gall1" title="放大檢視相關照片第 {{ $k + 1 }} 張" aria-label="放大檢視相關照片第 {{ $k + 1 }} 張">
                                        <img src="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/photos/'.$v) }}" alt="{{ $post->title }}的相關圖片第 {{ $k + 1 }} 張" class="img-thumbnail w-100">
                                    </a>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                <!-- 附件下載區塊 -->
                @if(!empty($files) and $can_see)                    
                    <section class="card my-4 shadow-sm border" aria-label="附件下載區塊">
                        <h2 class="card-header bg-light h5 fw-bold py-3">附件下載</h2>
                        <div class="card-body">
                        @foreach($files as $k => $v)
                            <?php 
                                $ext = pathinfo($v, PATHINFO_EXTENSION);
                            ?>
                            <a href="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/files/'.$v) }}" 
                               class="btn btn-outline-primary btn-sm my-1 me-1" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               title="下載附件：{{ $v }} (副檔名：{{ $ext }}，另開新視窗)"
                               aria-label="下載附件：{{ $v }} (副檔名：{{ $ext }}，另開新視窗)">
                                <i class="fas fa-download me-1" aria-hidden="true"></i> {{ $v }}
                                <span class="visually-hidden">(副檔名：{{ $ext }}，另開新視窗)</span>
                            </a>
                        @endforeach
                        </div>
                    </section>                    
                @endif            
            </div>

            <!-- 側邊欄區塊 -->
            <aside class="col-lg-4" aria-label="側邊欄資訊">
                <div class="card my-2 shadow-sm border">
                    <h2 class="card-header bg-light h5 fw-bold py-3">近月內熱門公告</h2>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                        @foreach($hot_posts as $hot_post)
                            <li class="mb-2 pb-2 border-bottom">
                                <small class="text-muted me-1">{{ substr($hot_post->created_at,0,10) }}</small>
                                <span class="badge bg-danger ms-1" title="點閱數 {{ $hot_post->views }} 次" aria-label="點閱數 {{ $hot_post->views }} 次">{{ $hot_post->views }}</span>
                                <br>
                                <a href="{{ route('posts.show',$hot_post->id) }}" class="fw-normal text-decoration-none" title="閱讀公告：{{ $hot_post->title }}" aria-label="閱讀公告：{{ $hot_post->title }}">
                                    {{ $hot_post->title }}
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

<!-- 置頂日期選擇 Modal (垂直置中 modal-dialog-centered + 高階層 z-index) -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold" id="exampleModalLabel">置頂設定</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="關閉視窗"></button>
            </div>
            <form id="top_up_form" action="{{ route('posts.top_up2',$post->id) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="top_date" class="form-label fw-bold">置頂至哪一天？ <span class="text-danger">*</span></label>
                        <input type="date" name="top_date" id="top_date" class="form-control" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary" onclick="return send_form();">送出置頂</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function send_form(){
        if($('#top_date').val().length === 0){
            sw_alert('請選日期！');
            return false;
        }
        return true;
    }
</script>
@endsection