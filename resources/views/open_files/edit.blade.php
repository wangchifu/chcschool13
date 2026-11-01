@extends('layouts.master_clean')
<?php $openfile_name = (empty($setup->openfile_name))?"檔案庫":$setup->openfile_name; ?>
@section('title', '編輯'.$openfile_name.' | ')

@section('content')
<div class="container py-3">
    <h1 class="h4 mb-3">編輯{{ $openfile_name }}項目</h1>
    
    @include('layouts.errors')

    <form action="{{ route('open_files.update', $upload->id) }}" method="POST" aria-label="編輯{{ $openfile_name }}項目表單" id="this_form1">
        @csrf
        @method('PATCH')

        <!-- 無障礙 HM1010301C 修正：標準語意化 Form 結構 -->
        <div class="card p-3 shadow-sm">
            <div class="mb-3">
                <!-- 無障礙 HM1150100C 修正：對應 Label -->
                <label for="name" class="fw-bold">項目名稱 <span class="text-danger">*</span></label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ $upload->name }}" 
                       class="form-control mb-2" 
                       required 
                       placeholder="請輸入名稱" 
                       aria-label="項目名稱">

                @if($upload->type == 3)
                    <label for="url" class="fw-bold mt-2">雲端連結網址 <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="url" 
                           id="url" 
                           value="{{ $upload->url }}" 
                           class="form-control" 
                           required 
                           placeholder="請輸入連結 (例如: https://...)" 
                           aria-label="雲端連結網址">
                @endif
            </div>

            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','this_form1')">
                    <i class="fas fa-save me-1" aria-hidden="true"></i> 儲存變更
                </button>
            </div>
        </div>

        <input type="hidden" name="path" value="{{ $path }}">
    </form>
</div>
@endsection