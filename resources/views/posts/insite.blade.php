@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', '公告系統：內部公告 | ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <!-- 頁面主標題 -->
        <h1 class="my-3">公告系統：內部公告</h1>

        <!-- 無障礙 HM1010301C 修正：公告分類頁籤 -->
        <nav aria-label="公告分類頁籤">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="{{ route('posts.index') }}">一般公告</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary" href="{{ route('posts.honor') }}">
                        <!-- 無障礙 HM1120201C 修正：裝飾性圖示隱藏 -->
                        <img src="{{ asset('images/gold-medal.svg') }}" width="16" alt="" aria-hidden="true" class="me-1">榮譽榜
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="{{ route('posts.insite') }}" aria-current="page">內部公告</a>
                </li>
            </ul>
        </nav>

        <!-- 主要公告列表區塊 -->
        <main aria-label="內部公告清單">
            @include('posts.list')
        </main>

        <!-- 無障礙 HM1150100C 修正：分頁導覽區塊 -->
        <nav aria-label="內部公告頁碼分頁導覽" class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </nav>
    </div>
</div>
@endsection