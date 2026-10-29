@extends('layouts.master_clean')

@section('title', '批次刪除公告 | ')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-10 col-lg-8">

        <!-- 頂部強烈警告 Alert 區塊 -->
        <div class="alert alert-danger shadow-sm border-0 d-flex align-items-center mb-4 p-3" role="alert">
            <i class="fas fa-exclamation-triangle fa-2x me-3 flex-shrink-0"></i>
            <div>
                <h5 class="alert-heading fw-bold mb-1">強烈警告注意事項</h5>
                <p class="mb-0">此操作將進行大量且無法復原的刪除程序，做錯了無法復原，請務必再次確認參數！</p>
            </div>
        </div>

        <!-- 主卡片容器 -->
        <div class="card shadow-sm border-danger">
            <!-- 卡片頁首 -->
            <div class="card-header bg-danger text-white fw-bold py-3 d-flex justify-content-between align-items-center">
                <span style="font-size: 1.1rem;">
                    <i class="fas fa-trash-restore me-2"></i> 批次刪除公告系統
                </span>
                <span class="badge bg-white text-danger fw-bold">高風險操作</span>
            </div>

            <!-- 表單區塊 -->
            <form action="{{ route('setups.batch_delete') }}" method="POST" id="this_form1">
                @csrf
                @method('DELETE')

                <div class="card-body bg-light p-4">

                    <!-- 步驟一：填寫起始刪除編號 -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body bg-white rounded p-3">
                            <label for="post_no" class="form-label fw-bold text-dark mb-2">
                                <span class="badge bg-primary me-1">步驟 1</span> 要從哪一篇文章的公告開始刪到最前面？
                            </label>

                            <!-- 示意圖呈現區塊 -->
                            <div class="my-3 text-center bg-light p-3 border rounded">
                                <div class="text-muted small mb-2">
                                    <i class="fas fa-info-circle me-1"></i> 請參考下圖紅色框處，尋找您要刪除的起始「公告編號」：
                                </div>
                                <img src="{{ asset('images/post_no.png') }}" class="img-fluid border rounded shadow-sm" alt="公告編號示意圖">
                            </div>

                            <input type="number" name="post_no" id="post_no" class="form-control" placeholder="請填寫起始刪除的公告編號 (例如：105)" required>
                        </div>
                    </div>

                    <!-- 步驟二：選擇刪除公告類別 -->
                    <div class="card mb-2 border-0 shadow-sm">
                        <div class="card-body bg-white rounded p-3">
                            <label for="insite" class="form-label fw-bold text-danger mb-2">
                                <span class="badge bg-danger me-1">步驟 2</span> 請選擇要刪除的公告類別 *
                            </label>
                            <select name="insite" id="insite" class="form-select">
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <!-- 頁尾儲存/執行按鈕 -->
                <div class="card-footer bg-light text-end py-3 border-top">
                    <button class="btn btn-danger px-4" id="this_form1_button" type="button" onclick="sw_confirm2('真的確定嗎？太大量的話，請等一下，不要再亂按了','this_form1','this_form1_button')">
                        <i class="fas fa-trash-alt me-1"></i> 確定不能挽回的刪除大量公告
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection