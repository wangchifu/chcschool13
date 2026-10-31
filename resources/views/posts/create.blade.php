@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', '新增公告 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- 麵包屑導覽列 -->
            <nav aria-label="breadcrumb" class="my-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none">公告列表</a></li>
                    <li class="breadcrumb-item active" aria-current="page">新增公告</li>
                </ol>
            </nav>

            <h1 class="my-3 fw-bold">
                @if(empty($setup->post_name))
                  公告系統
                @else
                  {{ $setup->post_name }}
                @endif
            </h1>

            <!-- 新增公告純 HTML 表單 -->
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="this_form1">
                @csrf
                <div class="card my-3 shadow-sm border">
                    <div class="card-header bg-light text-dark fw-bold py-3">
                        <span style="font-size: 1.1rem;">
                            <i class="fas fa-plus-circle me-2 text-primary"></i> 公告資料
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <!-- 1. 職稱 -->
                        <div class="mb-3">
                            <?php $job_title = (auth()->user()->username=="admin")?"系統管理":auth()->user()->title; ?>
                            <label for="job_title" class="form-label fw-bold">
                                <strong class="text-danger">1.職稱*</strong> 
                                <a href="{{ route('edit_title') }}" class="text-decoration-none ms-1">更改</a>
                            </label>
                            <input type="text" name="job_title" id="job_title" value="{{ $job_title }}" class="form-control" readonly="readonly">
                        </div>

                        <!-- 2. 公告類別 -->
                        <div class="mb-3">
                            <label for="insite" class="form-label fw-bold"><strong class="text-danger">2.公告類別*</strong></label>
                            <select name="insite" id="insite" class="form-select">
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 3. 標題圖片 -->
                        <div class="mb-3">
                            <label for="title_image" class="form-label">
                                <a data-bs-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3" class="text-dark text-decoration-none fw-bold">
                                    3.標題圖片( 不大於5MB ) <i class="fas fa-chevron-down small text-muted ms-1"></i>
                                </a>                            
                                <small class="text-secondary ms-1">jpeg, png 檔</small>
                            </label>
                            <div class="collapse" id="collapse3">
                                <input type="file" name="title_image" id="title_image" class="form-control" accept="image/jpeg,image/png">
                            </div>
                        </div>

                        <!-- 4. 標題 -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold"><strong class="text-danger">4.標題*</strong></label>
                            <input type="text" name="title" id="title" class="form-control" required="required" placeholder="請輸入標題">
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
                                                <input type="date" name="live_date" id="live_date" class="form-control form-control-sm mb-1" onchange="check_today()">
                                                <input type="time" name="live_time" id="live_time" class="form-control form-control-sm">
                                                <small class="text-muted d-block mt-1">(不填代表即刻貼出)</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="die_date" class="form-label small fw-bold mb-1">迄(含)</label>
                                                <input type="date" name="die_date" id="die_date" class="form-control form-control-sm" onchange="check_date()">
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
                            <textarea name="content" id="small_editor" class="form-control" rows="10" required="required" placeholder="請輸入內容"></textarea>
                        </div>                                        
                        
                        @include('layouts.hd')                    

                        <!-- 7. 相關照片 -->
                        <div class="mb-3">
                            <label for="photos" class="form-label fw-bold">7.相關照片( 單檔不大於5MB的圖檔 )</label>
                            <small class="text-danger d-block mb-1">(注意！請勿將公告當成圖庫相簿使用，單次也不要超過十張以上的照片，若造成伺服器負擔，經查證將取消貴校此功能。)</small>
                            @if($per < 100)
                                <input type="file" name="photos[]" id="photos" class="form-control" multiple="multiple" accept="image/*">
                            @else
                                <span class="text-danger fw-bold d-block mt-1">容量已滿！無法上傳照片了！</span>
                            @endif
                        </div>

                        <!-- 8. 附件 -->
                        <div class="mb-3">
                            <label for="files" class="form-label fw-bold">
                                8.附件( 不大於10MB，若為文字檔，請改為[ <a href="https://moda.gov.tw/digital-affairs/digital-service/app-services/248" target="_blank" class="text-decoration-none">ODF格式</a> ] [ <a href="{{ asset('ODF.pdf') }}" target="_blank" class="text-decoration-none">詳細公文</a> ] [ <a href="{{ asset('office2016_odt_pdf.png') }}" target="_blank" class="text-decoration-none">轉檔教學</a> ] )
                                <small class="text-secondary d-block fw-normal">csv, txt, zip, jpeg, png, pdf, odt, ods, mp3 檔</small>
                            </label>
                            @if($per < 100)
                                <input type="file" name="files[]" id="files" class="form-control" multiple="multiple">
                            @else
                                <span class="text-danger fw-bold d-block mt-1">容量已滿！無法加附件！</span>
                            @endif
                        </div>                  

                        @if($setup->post_line_bot_token)
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="send_line_bot_token" name="send_line_bot_token" value="yes">
                            <label class="form-check-label text-danger" for="send_line_bot_token">
                                <i class="fab fa-line text-success h4 align-middle me-1"></i> 同步發至 line bot (1.未來公告則不會發出，2.僅有200則免費的推播，群組一則以總人數計)
                            </label>
                        </div>
                        @endif

                        <!-- 按鈕區 -->
                        <div class="mt-4">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm me-1">
                                <i class="fas fa-backward me-1"></i> 返回
                            </a>
                            <button type="button" id="this_form1_button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定送出？','this_form1','this_form1_button')">
                                <i class="fas fa-save me-1"></i> 儲存設定
                            </button>
                        </div>
                        @include('layouts.errors')
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