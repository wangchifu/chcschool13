@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '網站設定 | ')

@section('my_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1>網站設定</h1>

            <?php
            $active[1] = "";
            $active[2] = "";
            $active[3] = "";
            $active[4] = "";
            $active[5] = "";
            $active[6] = "";
            $active[7] = "active";
            ?>
            @include('setups.nav', $active)

            <!-- 頂部標題區 -->
            <div class="d-flex justify-content-between align-items-center my-3">
                <h3 class="m-0">網站導覽頁面內容編輯</h3>
            </div>

            <!-- 主卡片容器與表單 -->
            <form action="{{ route('setups.sitemap_store') }}" method="POST" id="this_form1">
                @csrf
                <div class="card my-3 shadow-sm border">
                    <!-- 頁首：bg-light text-dark -->
                    <div class="card-header bg-light text-dark fw-bold d-flex justify-content-between align-items-center py-3">
                        <span style="font-size: 1.1rem;">
                            <i class="fas fa-sitemap me-2 text-primary"></i> 網站導覽 (Sitemap) 內容設定
                        </span>                        
                    </div>
                    <textarea name="sitemap" id="tiny_editor" class="form-control" rows="30" required placeholder="請輸入網站導覽相關內容及定位點說明...">{{ $setup->sitemap }}</textarea>                  
                <!-- 頁尾儲存按鈕 -->
                    <div class="card-footer bg-light text-end py-3">
                        <button type="button" id="this_form1_button" class="btn btn-primary px-4" onclick="sw_confirm2('您確定送出嗎','this_form1','this_form1_button')">
                            <i class="fas fa-save me-1"></i> 儲存網站導覽設定
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>    
@endsection

@section('at_bottom_js')    
    <script src="https://cdn.tiny.cloud/1/t3x62bustao4bqhd7m12sm2o54zuql6jdimapxaxkwc0swtb/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
@endsection