@extends('layouts.master_clean')

@section('title', '新增欄位 | ')

@section('content')
<div class="container-fluid py-3">
    @include('layouts.errors')
    
    <!-- 主卡片容器 -->
    <div class="card shadow-sm border">
        <!-- 卡片頁首 -->
        <div class="card-header bg-light text-dark fw-bold py-3 d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem;">
                <i class="fas fa-columns me-2 text-primary"></i> 新增頁面欄位結構
            </span>
        </div>

        <!-- 表單內容區塊 -->
        <form action="{{ route('setups.add_col') }}" method="POST" id="this_form1">
            @csrf
            <div class="card-body bg-light p-3">
                <div class="row g-3">
                    
                    <!-- 1. 排序 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="order_by" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-secondary me-1">1</span> 排序
                                </label>
                                <input type="text" name="order_by" id="order_by" class="form-control" placeholder="請填數字 (數字小者優先)">
                            </div>
                        </div>
                    </div>

                    <!-- 2. 名稱 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="title" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-primary me-1">2</span> 欄位名稱 <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="例如：主要內容區" required="required">
                            </div>
                        </div>
                    </div>

                    <!-- 3. 欄位寬度比例 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="num" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-info text-dark me-1">3</span> 寬度比例 (1-12整數) <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="num" id="num" class="form-control" placeholder="例如：8" required="required" maxlength="2">
                                <div class="form-text text-muted small mt-1">預設滿版為 12，多欄請自訂比例</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 卡片頁尾操作按鈕 -->
            <div class="card-footer bg-light text-end py-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-success px-4" onclick="sw_confirm2('確定新增？','this_form1','this_form1_button')">
                    <i class="fas fa-plus me-1"></i> 新增欄位
                </button>
            </div>
        </form>
    </div>
</div>

@endsection