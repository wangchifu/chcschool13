@extends('layouts.master_clean')

@section('title', '編輯欄位 | ')

@section('content')
<div class="container-fluid py-3">
    @include('layouts.errors')

    <!-- 主卡片容器 -->
    <div class="card shadow-sm border">
        <!-- 卡片頁首與刪除按鈕區塊 -->
        <div class="card-header bg-light text-dark fw-bold py-3 d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem;">
                <i class="fas fa-columns me-2 text-primary"></i> 編輯頁面欄位結構
            </span>
            <form action="{{ route('setups.delete_col', $setup_col->id) }}" method="POST" class="d-inline" id="delete_form">
                @csrf
                @method('DELETE')
                <button type="button" id="delete_form_button" class="btn btn-outline-danger btn-sm" onclick="sw_confirm2('確定刪除？若有區塊放置在此欄位，記得去變更！','delete_form','delete_form_button')">
                    <i class="fas fa-trash-alt me-1"></i> 刪除欄位
                </button>
            </form>
        </div>

        <!-- 編輯表單內容區塊 -->
        <form action="{{ route('setups.update_col', $setup_col->id) }}" method="POST" id="this_form1">
            @csrf
            @method('PATCH')

            <div class="card-body bg-light p-3">
                <div class="row g-3">
                    
                    <!-- 1. 排序 -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-3">
                                <label for="order_by" class="form-label fw-bold text-dark mb-2">
                                    <span class="badge bg-secondary me-1">1</span> 排序
                                </label>
                                <input type="text" name="order_by" id="order_by" class="form-control" value="{{ $setup_col->order_by }}" placeholder="數字">
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
                                <input type="text" name="title" id="title" class="form-control" value="{{ $setup_col->title }}" required="required">
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
                                <input type="text" name="num" id="num" class="form-control" value="{{ $setup_col->num }}" required="required" maxlength="2">
                                <div class="form-text text-muted small mt-1">預設滿版為 12，多欄請自訂比例</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 卡片頁尾操作按鈕 -->
            <div class="card-footer bg-light text-end py-3 border-top">
                <button type="button" id="this_form1_button" class="btn btn-primary px-4" onclick="sw_confirm2('確定？','this_form1','this_form1_button')">
                    <i class="fas fa-save me-1"></i> 儲存變更
                </button>
            </div>
        </form>
    </div>
</div>

@endsection