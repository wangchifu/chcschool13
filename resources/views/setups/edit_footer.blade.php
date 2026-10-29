@extends('layouts.master_clean')

@section('title', '編輯置底 | ')

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
                <i class="fas fa-shoe-prints me-2 text-primary"></i> 編輯頁尾 (Footer) 置底內容
            </span>
        </div>

        <!-- 表單區塊 -->
        <form action="{{ route('setups.update_footer') }}" method="POST" id="this_form1">
            @csrf
            @method('PATCH')

            <div class="card-body bg-light p-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-white rounded p-3">
                        <label for="footer" class="form-label fw-bold text-dark mb-2">
                            <i class="fas fa-align-left me-1 text-info"></i> 置底內容文字與 HTML 編輯
                        </label>
                        <textarea name="footer" id="tiny_editor" class="form-control" rows="10">{{ $setup->footer }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 卡片頁尾操作按鈕 -->
            <div class="card-footer bg-light text-end py-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-primary px-4" onclick="sw_confirm2('確定儲存？','this_form1','this_form1_button')">
                    <i class="fas fa-save me-1"></i> 儲存置底
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('at_bottom_js')    
    <script src="https://cdn.tiny.cloud/1/t3x62bustao4bqhd7m12sm2o54zuql6jdimapxaxkwc0swtb/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
@endsection