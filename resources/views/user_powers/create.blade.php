@extends('layouts.master_clean')

@section('title', '新增使用者權限 | ')

@section('in_head_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chosen-js@1.8.7/chosen.min.css">
    <style>
        /* 為 iframe 頁面底部預留足夠的選單展開空間，替代 <br> */
        body {
            padding-bottom: 220px !important;
        }
    </style>
@endsection

@section('content')
<div class="p-2">
    <!-- 主卡片容器 -->
    <div class="card shadow-sm border">
        <!-- 卡片頁首 -->
        <div class="card-header bg-light text-dark fw-bold py-2 px-3 d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-user-shield me-2 text-primary"></i> 新增使用者模組權限
            </span>
        </div>

        <!-- 表單內容區塊 -->
        <form action="{{ route('user_powers.store') }}" method="POST" id="this_form1">
            @csrf
            <div class="card-body bg-light p-2">
                <div class="row g-2">
                    
                    <!-- 1. 模組名稱 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-2">
                                <label class="form-label fw-bold text-dark mb-1 small">
                                    <span class="badge bg-secondary me-1">1</span> 模組名稱
                                </label>
                                <div class="form-control-plaintext fw-bold text-primary ps-1 py-0">
                                    <i class="fas fa-cube me-1"></i> {{ $module }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. 選擇使用者 -->
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-2">
                                <label for="user_id" class="form-label fw-bold text-dark mb-1 small">
                                    <span class="badge bg-primary me-1">2</span> 選擇使用者 <span class="text-danger">*</span>
                                </label>
                                <select name="user_id" id="user_id" class="form-control search_selet">
                                    <option value=""></option>
                                    @foreach($users as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. 權限類別 -->
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-2">
                                <label class="form-label fw-bold text-dark mb-1 small">
                                    <span class="badge bg-info text-dark me-1">3</span> 權限類別
                                </label>
                                <div class="form-control-plaintext fw-bold text-dark ps-1 py-0">
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 隱藏欄位傳遞 -->
            <input type="hidden" name="name" value="{{ $module }}">
            <input type="hidden" name="type" value="{{ $type }}">

            <!-- 卡片頁尾操作按鈕 -->
            <div class="card-footer bg-light text-end py-2 px-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-success btn-sm px-3" onclick="sw_confirm2('確定嗎？','this_form1','this_form1_button')">
                    <i class="fas fa-plus me-1"></i> 新增權限
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('at_bottom_js') 
    <script src="https://cdn.jsdelivr.net/npm/chosen-js@1.8.7/chosen.jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".search_selet").chosen({
                search_contains: true,
                width: "100%"
            });
        });
    </script>
@endsection