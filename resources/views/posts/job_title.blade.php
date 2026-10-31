@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', $job_title.' 職稱搜尋 | ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <!-- 頁面主標題 -->
        <h1 class="my-3">{{ $job_title }} 公告</h1>

        <!-- 麵包屑導覽列 -->
        <nav aria-label="麵包屑導覽" class="my-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none">公告列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $job_title }} 職稱搜尋</li>
            </ol>
        </nav>

        <!-- 主要列表區塊 -->
        <main aria-label="{{ $job_title }} 的公告清單">
            @include('posts.list')
        </main>

        <!-- 分頁導覽區塊 -->
        @if($posts->hasPages())
            <nav aria-label="{{ $job_title }} 搜尋結果頁碼分頁導覽" class="d-flex justify-content-center mt-3">
                {{ $posts->links() }}
            </nav>
        @endif
    </div>
</div>
@endsection