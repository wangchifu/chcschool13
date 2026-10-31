@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', '修改公告 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- 麵包屑導覽列 -->
            <nav aria-label="breadcrumb" class="my-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none">公告列表</a></li>
                    <li class="breadcrumb-item active" aria-current="page">修改公告</li>
                </ol>
            </nav>

            <h1 class="my-3 fw-bold"><i class="fas fa-bullhorn me-2 text-primary"></i> 修改公告</h1>

            <!-- 修改公告純 HTML 表單 -->
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="this_form1">
                @csrf
                @method('PATCH')

                <div class="card my-3 shadow-sm border">
                    <div class="card-header bg-light text-dark fw-bold py-3">
                        <span style="font-size: 1.1rem;">
                            <i class="fas fa-edit me-2 text-primary"></i> 公告資料
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @include('layouts.errors')

                        <!-- 1. 職稱 -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold"><strong class="text-danger">1.職稱*</strong></label>
                            <input type="text" name="job_title" id="title" value="{{ old('job_title', $post->job_title) }}" class="form-control">
                        </div>

                        <!-- 2. 公告類別 -->
                        <div class="mb-3">
                            <label for="insite" class="form-label fw-bold"><strong class="text-danger">2.公告類別*</strong></label>
                            <select name="insite" id="insite" class="form-select">
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ $key == old('insite', $post->insite) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 3. 標題圖片 -->
                        <div class="mb-3">
                            <label for="title_image" class="form-label">
                                <a data-bs-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3" class="text-dark text-decoration-none fw-bold">
                                    3.標題圖片( 不大於5MB ) <i class="fas fa-chevron-down small text-muted ms-1"></i>
                                </a>
                            </label>
                            <div class="collapse" id="collapse3">
                                @if($title_image)
                                    <?php
                                    $file = "posts/".$post->id."/title_image.png";
                                    $file = str_replace('/','&',$file);
                                    ?>
                                    <div class="mb-2">
                                        <a href="{{ route('posts.delete_title_image',$post->id) }}" class="badge bg-danger text-decoration-none p-2" id="fileDel" onclick="return confirm('確定刪標題圖片')">
                                            <i class="fas fa-times-circle me-1"></i> 刪除標題圖片
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="title_image" id="title_image" class="form-control">
                            </div>
                        </div>

                        <!-- 4. 標題 -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold"><strong class="text-danger">4.標題*</strong></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="form-control" placeholder="請輸入標題" required="required">
                        </div>

                        <!-- 5. 上架起迄日期 -->
                        <div class="mb-3">
                            <p class="mb-1">
                                <a data-bs-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5" class="text-dark text-decoration-none fw-bold">
                                    5.上架起迄日期 ( 可不填 ) <i class="fas fa-chevron-down small text-muted ms-1"></i>
                                </a>
                                [<a href="{{ asset('live_date.png') }}" target="_blank" class="text-decoration-none">教學</a>]
                            </p>
                            <div class="collapse" id="collapse5">
                                <div class="p-3 bg-light rounded border mt-2" style="max-width: 360px;">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="live_date" class="form-label small fw-bold mb-1">起</label>
                                                <input type="date" name="live_date" id="live_date" value="{{ old('live_date', substr($post->created_at,0,10)) }}" class="form-control form-control-sm mb-1" onchange="check_today()">
                                                <input type="time" name="live_time" id="live_time" value="{{ old('live_time', substr($post->created_at,11,8)) }}" class="form-control form-control-sm">
                                                <small class="text-muted d-block mt-1">(不填代表即刻貼出)</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="die_date" class="form-label small fw-bold mb-1">迄(含)</label>
                                                <input type="date" name="die_date" id="die_date" value="{{ old('die_date', $post->die_date) }}" class="form-control form-control-sm" onchange="check_date()">
                                                <small class="text-muted d-block mt-1">(不填代表不下架)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                        </div>

                        <!-- 6. 內文 -->
                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold"><strong class="text-danger">6.內文*</strong></label>
                            <textarea name="content" id="small_editor" class="form-control" rows="10" placeholder="請輸入內容" required="required">{{ old('content', $post->content) }}</textarea>
                        </div>                        

                        @include('layouts.hd')

                        <!-- 7. 相關照片 -->
                        <div class="mb-3">
                            <label for="photos" class="form-label fw-bold">7.相關照片( 單檔不大於5MB的圖檔 )</label>
                            <small class="text-danger d-block mb-2">(注意！請勿將公告當成圖庫相簿使用，單次也不要超過十張以上的照片，若造成伺服器負擔，經查證將取消貴校此功能。)</small>
                            
                            @if(!empty($photos))
                                <div class="row g-2 mb-3">
                                    @foreach($photos as $k=>$v)
                                    <div class="col-md-2 col-4 text-center">
                                        <figure class="figure border p-1 rounded bg-light w-100 mb-0">
                                            <img src="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/photos/'.$v) }}" class="figure-img img-fluid rounded mb-1" style="max-height: 120px; object-fit: cover;" alt="圖片：{{ $v }}">
                                            <figcaption class="figure-caption">
                                                <a href="{{ route('posts.delete_photo',['post'=>$post->id,'filename'=>$v]) }}" class="badge bg-danger text-decoration-none d-block py-1" onclick="return confirm('確定刪除？')">
                                                    <i class="fas fa-times-circle me-1"></i> {{ $v }}
                                                </a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($per < 100)
                                <input type="file" name="photos[]" id="photos" class="form-control" multiple="multiple" accept="image/*">
                            @else
                                <span class="text-danger fw-bold d-block mt-1">容量已滿！無法上傳照片了！</span>
                            @endif
                        </div>

                        <!-- 8. 附件 -->
                        <div class="mb-3">
                            <label for="files" class="form-label fw-bold">
                                8.附件( 不大於10MB，若為文字檔，請改為[ <a href="https://moda.gov.tw/digital-affairs/digital-service/app-services/248" target="_blank" class="text-decoration-none">ODF格式</a> ] [ 詳細公文 ] [ 轉檔教學 ] )
                                <small class="text-secondary d-block fw-normal">csv, txt, zip, jpeg, png, pdf, odt, ods, mp3 檔</small>
                            </label>

                            @if(!empty($files))
                                <div class="mb-2">
                                    @foreach($files as $k=>$v)
                                        <a href="{{ route('posts.delete_file',['post'=>$post->id,'filename'=>$v]) }}" class="badge bg-danger text-decoration-none me-1 mb-1 p-2" onclick="return confirm('確定刪除？')">
                                            <i class="fas fa-times-circle me-1"></i> {{ $v }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            @if($per < 100)
                                <input type="file" name="files[]" id="files" class="form-control" multiple="multiple">
                            @else
                                <span class="text-danger fw-bold d-block mt-1">容量已滿！無法加附件！</span>
                            @endif
                        </div>

                        <!-- 按鈕區 -->
                        <div class="mt-4">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm me-1">
                                <i class="fas fa-backward me-1"></i> 返回
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定修改嗎？','this_form1')">
                                <i class="fas fa-save me-1"></i> 儲存設定
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
@endsection

@section('at_bottom_js')    
    <script src="https://cdn.tiny.cloud/1/t3x62bustao4bqhd7m12sm2o54zuql6jdimapxaxkwc0swtb/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script>
        function check_date(){                                        
            if($('#die_date').val() < $('#live_date').val() & document.getElementById("die_date").value !== ""){
                $('#die_date').val("");
                sw_alert('迄日，不得小於起日！');
            }
        }
        function check_today(){                               
            check_date();         
            if('{{ date('Y-m-d') }}'> $('#live_date').val()){
                $('#live_date').val("");
                sw_alert('不能選今天以前的日子！');
            }
        }
    </script>
@endsection