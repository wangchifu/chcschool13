@extends('layouts.master_clean')

@section('title', '新增區塊 | ')

@section('my_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid py-3">
    @include('layouts.errors')

    <!-- 主卡片容器 -->
    <div class="card shadow-sm border">
        <!-- 卡片頁首 -->
        <div class="card-header bg-light text-dark fw-bold py-3 d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem;">
                <i class="fas fa-plus-circle me-2 text-primary"></i> 新增頁面區塊
            </span>
        </div>

        <!-- 表單內容區塊 -->
        <form action="{{ route('setups.add_block') }}" method="POST" id="this_form1">
            @csrf
            <div class="card-body bg-light p-3">
                <div class="row g-3">
                    
                    <!-- 1. 放置欄位 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="setup_col_id" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-secondary me-1">1</span> 放置欄位
                                </label>
                                <select name="setup_col_id" id="setup_col_id" class="form-select">
                                    <option value=""></option>
                                    @foreach($setup_array as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 2. 排序 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="order_by" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-secondary me-1">2</span> 排序
                                </label>
                                <input type="text" name="order_by" id="order_by" class="form-control" placeholder="請填數字 (數字小者優先)">
                            </div>
                        </div>
                    </div>

                    <!-- 3. 名稱 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="title" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-primary me-1">3</span> 名稱 <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="請輸入區塊名稱" required="required">
                            </div>
                        </div>
                    </div>

                    <!-- 4. 顏色 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="block_color" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">4</span> <a href="{{ route('setups.block_color') }}" class="text-decoration-none">顏色</a>
                                </label>
                                <select name="block_color" id="block_color" class="form-select">
                                    <option value=""></option>
                                    @foreach($block_colors as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 5. 標題位置 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="block_position" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">5</span> 標題位置
                                </label>
                                <select name="block_position" id="block_position" class="form-select">
                                    <option value="text-left">置左</option>
                                    <option value="text-center">置中</option>
                                    <option value="text-right">置右</option>
                                    <option value="disable">不顯示標題</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 6. 框線 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="disable_block_line" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">6</span> 框線
                                </label>
                                <select name="disable_block_line" id="disable_block_line" class="form-select">
                                    <option value="">*有*框線</option>
                                    <option value="1">*無*框線</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 7. 內文編輯器 -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="my-editor" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-primary me-1">7</span> 內文 <span class="text-danger">*</span>
                                </label>
                                <textarea name="content" id="tiny_editor" class="form-control" required="required"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 卡片頁尾操作按鈕 -->
            <div class="card-footer bg-light text-end py-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-success px-4" onclick="sw_confirm2('確定新增？','this_form1','this_form1_button')">
                    <i class="fas fa-plus me-1"></i> 新增區塊
                </button>
            </div>
        </form>
    </div>

    <!-- 標題底色參考區域 -->
    <div class="mt-4 p-3 bg-white border rounded shadow-sm">
        <span class="fw-bold text-dark"><i class="fas fa-palette me-1 text-info"></i> 標題底色參考：</span><br>
        <a href="{{ route('setups.block_color') }}" class="d-inline-block mt-2">
            <img src="{{ asset('color.png') }}" class="img-thumbnail" alt="標題底色參考">
        </a>
    </div>
</div>
@endsection

@section('at_bottom_js')    
    <script src="https://cdn.tiny.cloud/1/t3x62bustao4bqhd7m12sm2o54zuql6jdimapxaxkwc0swtb/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
@endsection