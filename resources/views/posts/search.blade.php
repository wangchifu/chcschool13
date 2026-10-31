@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', '搜尋「'.$search.'」公告 | ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <!-- 頁面主標題 -->
        <h1 class="my-3">搜尋「{{ $search }}」公告</h1>

        <!-- 麵包屑導覽列 -->
        <nav aria-label="麵包屑導覽" class="my-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none">公告列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">關鍵字搜尋</li>
            </ol>
        </nav>

        <!-- 主要搜尋結果清單區塊 -->
        <main aria-label="關鍵字「{{ $search }}」的公告搜尋結果">
            @include('posts.list')
        </main>

        <!-- 分頁導覽區塊 -->
        <nav aria-label="關鍵字「{{ $search }}」搜尋結果頁碼分頁導覽" class="d-flex justify-content-center mt-3">
            {{ $posts->appends(['search'=>$search])->links() }}
        </nav>
    </div>
</div>
@endsection