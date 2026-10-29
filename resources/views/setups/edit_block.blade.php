@extends('layouts.master_clean')

@section('title', '編輯區塊 | ')

@section('my_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid py-3">
    @include('layouts.errors')

    <!-- 主卡片容器 -->
    <div class="card shadow-sm border">
        <!-- 卡片頁首與刪除按鈕區塊 -->
        <div class="card-header bg-light text-dark fw-bold py-3 d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem;">
                <i class="fas fa-edit me-2 text-primary"></i> 編輯區塊內容與設定
            </span>

            @if(strpos($block->title, "跑馬燈"))
            @elseif(!strpos($block->title, '系統區塊'))
                <form action="{{ route('setups.delete_block', $block->id) }}" method="POST" class="d-inline" id="delete_form">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="delete_form_button" class="btn btn-outline-danger btn-sm" onclick="sw_confirm2('確定刪除？','delete_form','delete_form_button')">
                        <i class="fas fa-trash-alt me-1"></i> 刪除區塊
                    </button>
                </form>
            @endif
        </div>

        <!-- 編輯表單內容區塊 -->
        <form action="{{ route('setups.update_block', $block->id) }}" method="POST" id="this_form1">
            @csrf
            @method('PATCH')

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
                                        <option value="{{ $key }}" {{ $block->setup_col_id == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                <input type="text" name="order_by" id="order_by" class="form-control" value="{{ $block->order_by }}" placeholder="數字">
                            </div>
                        </div>
                    </div>

                    <!-- 3. 標題名稱 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="title" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-primary me-1">3</span> 標題名稱 <span class="text-danger">*</span>
                                </label>
                                @if(str_contains($block->title, '系統區塊') or str_contains($block->title, '榮譽榜跑馬燈'))
                                    <?php 
                                        $new_title = (empty($block->new_title)) ? $block->title : $block->new_title;
                                        $new_title = str_replace('(系統區塊)', '', $new_title); 
                                    ?>
                                    <input type="text" name="new_title" id="new_title" class="form-control" value="{{ $new_title }}" required="required">
                                    <input type="hidden" name="title" value="{{ $block->title }}">
                                @else
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $block->title }}" required="required">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 4. 標題底色 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="block_color" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">4</span> <a href="{{ route('setups.block_color') }}" class="text-decoration-none">標題底色</a>
                                </label>
                                <select name="block_color" id="block_color" class="form-select">
                                    <option value=""></option>
                                    @foreach($block_colors as $key => $value)
                                        <option value="{{ $key }}" {{ $block->block_color == $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                <?php
                                    $select1 = ($block->block_position == "text-left" || $block->block_position == null) ? "selected" : "";
                                    $select2 = ($block->block_position == "text-center") ? "selected" : "";
                                    $select3 = ($block->block_position == "text-right") ? "selected" : "";
                                    $select4 = ($block->block_position == "disable") ? "selected" : "";
                                ?>
                                <select name="block_position" id="block_position" class="form-select">
                                    <option value="text-left" {{ $select1 }}>置左</option>
                                    <option value="text-center" {{ $select2 }}>置中</option>
                                    <option value="text-right" {{ $select3 }}>置右</option>
                                    <option value="disable" {{ $select4 }}>不顯示標題</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 6. 框線設定 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="disable_block_line" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">6</span> 框線
                                </label>
                                <?php 
                                    $line_select1 = ($block->disable_block_line == null) ? "selected" : "";
                                    $line_select2 = ($block->disable_block_line == "1") ? "selected" : "";
                                ?>
                                <select name="disable_block_line" id="disable_block_line" class="form-select">
                                    <option value="" {{ $line_select1 }}>*有*框線</option>
                                    <option value="1" {{ $line_select2 }}>*無*框線</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 7. 內文編輯器 / 跑馬燈提示 -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                @if(str_contains($block->title, '榮譽榜跑馬燈'))
                                    <div class="alert alert-light border mb-0" role="alert">
                                        <span class="text-danger fw-bold"><i class="fas fa-info-circle me-1"></i> 「榮譽榜跑馬燈」固定跑動樣式。</span>
                                    </div>
                                @elseif(!str_contains($block->title, '系統區塊'))
                                    <label for="my-editor" class="form-label fw-bold text-dark mb-2">
                                        <span class="badge bg-primary me-1">7</span> 內文 <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="content" id="tiny_editor" class="form-control" required="required">{{ $block->content }}</textarea>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 頁尾儲存按鈕 -->
            <div class="card-footer bg-light text-end py-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-primary px-4" onclick="sw_confirm2('確定儲存？','this_form1','this_form1_button')">
                    <i class="fas fa-save me-1"></i> 儲存區塊
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