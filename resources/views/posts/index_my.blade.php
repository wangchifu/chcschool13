@extends('layouts.master')

@section('nav_post_active', 'active')

@section('title', '我的公告 | ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <!-- 頁面主標題 -->
        <h1 class="my-3">
            @if(empty($setup->post_name))
              公告系統
            @else
              {{ $setup->post_name }}
            @endif
        </h1>

        @can('create', \App\Models\Post::class)
        <!-- 無障礙 HM1010301C 修正：導覽頁籤 -->
        <nav aria-label="公告類型切換" class="mb-3">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link text-secondary" href="{{ route('posts.index') }}">架上公告</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active fw-bold" href="{{ route('posts.index_my') }}" aria-current="page">我的公告</a>
                </li>
            </ul>
        </nav>

        <div class="mb-3">
            <!-- 無障礙 HM1120201C 修正：按鈕圖示補充 aria-hidden -->
            <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增公告
            </a>
        </div>
        @endcan

        <div class="table-responsive">
            <!-- 我的公告表格：樣式統一為 index / list.blade.php 的視覺風格 -->
            <table class="table table-striped table-hover align-middle mb-0" style="word-break:break-all;" aria-label="我的公告列表">
                <caption class="visually-hidden">我的公告管理與狀態清單</caption>
                <thead class="table-light">
                <tr>
                    <th scope="col" class="text-nowrap" style="width: 120px;">日期</th>
                    <th scope="col" class="text-nowrap" style="width: 110px;">類別</th>
                    <th scope="col" class="text-nowrap" style="min-width: 250px;">標題</th>
                    <th scope="col" class="text-nowrap" style="width: 120px;">發佈者</th>
                    <th scope="col" class="text-nowrap text-center" style="width: 60px;">點閱</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>                                
                            {{ substr($post->created_at,0,10) }}
                            @if($post->created_at > date('Y-m-d H:i:s'))
                                <div class="mt-1"><span class="badge bg-danger">尚未上架<br>{{ $post->created_at }}</span></div>
                            @endif
                            @if($post->die_date < date('Y-m-d') and $post->die_date != null)
                                <div class="mt-1"><span class="badge bg-dark">已經下架<br>{{ $post->die_date }}</span></div>
                            @endif
                            @if($post->die_date > date('Y-m-d') and $post->die_date != null)
                                <div class="mt-1"><span class="badge bg-warning text-dark">下架日期<br>{{ $post->die_date }}</span></div>
                            @endif
                        </td>
                        <td>
                            @if($post->insite == null)
                                <span class="text-decoration-none fw-bold" title="查看一般公告">一般公告</span>
                            @else
                                <span class="text-decoration-none fw-bold" title="查看{{ $post_types[$post->insite] }}">{{ $post_types[$post->insite] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($post->top)
                                <span class="badge bg-danger me-1">置頂</span>
                            @endif
                            @if($post->inbox)
                                <span class="badge bg-warning text-dark me-1">常駐</span>
                            @endif
                            <?php
                            if($post->insite==1){
                                if(auth()->check() or check_ip()){
                                    $can_see = 1;
                                }else{
                                    $can_see = 0;
                                }
                            }else{
                                $can_see = 1;
                            };
                            $school_code = school_code();                                
                            //有無附件
                            $files = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/files'));
                            $photos = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/photos'));
                            ?>
                            @if($can_see)
                                @if($post->insite==1)
                                    <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                @endif
                                <a href="{{ route('posts.show',$post->id) }}" class="text-decoration-none text-dark fw-bold" title="閱讀公告：{{ $post->title }}" aria-label="閱讀公告：{{ $post->title }}">{!! a11y_emoji($post->title) !!}</a>
                            @else
                                <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                <span class="text-secondary">{{ $post->title }}</span>
                            @endif

                            <!-- 無障礙 HM1120201C 修正：圖片與檔案圖示標示 -->
                            @if(!empty($photos))
                                <span class="text-success ms-1" title="附有圖片檔">
                                    <i class="fas fa-image" aria-hidden="true"></i>
                                    <span class="visually-hidden">（附有圖片檔）</span>
                                </span>
                            @endif
                            @if(!empty($files))
                                <span class="text-info ms-1" title="附有附件下載">
                                    <i class="fas fa-download" aria-hidden="true"></i>
                                    <span class="visually-hidden">（附有附件下載）</span>
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('posts.job_title',$post->job_title) }}" class="text-decoration-none text-secondary" title="查看發佈者 {{ $post->job_title }} 的所有公告" aria-label="查看發佈者 {{ $post->job_title }} 的所有公告">{{ $post->job_title }}</a>
                        </td>
                        <td class="text-center fw-bold text-secondary">
                            {{ $post->views }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- 無障礙 HM1150100C 修正：分頁導覽區塊 -->
        <nav aria-label="我的公告頁碼分頁導覽" class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </nav>
    </div>
</div>
@endsection 