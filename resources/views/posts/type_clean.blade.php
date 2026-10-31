@extends('layouts.master_clean')

@section('nav_post_active', 'active')

@section('title', $type_name.' 類別搜尋 | ')

@section('content')
<div class="row justify-content-center my-3">
    <main class="col-md-11" aria-label="類別搜尋公告結果">
        <!-- 頁面主標題 -->
        <h1 class="h2 mb-3 fw-bold">{{ $type_name }}</h1>

        <!-- 類別公告資料表格 -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle rwd-table mb-0" style="word-break:break-all;" aria-label="{{ $type_name }} 類別公告清單">
                <caption class="visually-hidden">{{ $type_name }} 類別下的公告清單列表，包含日期、類別、標題、發佈者與點閱數資訊</caption>
                <thead class="table-light">
                <tr>
                    <th scope="col" class="text-nowrap" style="width: 120px;">日期</th>
                    <?php
                        $post_type_array['a'] = "類別";
                        $post_type_array[0] = "一般公告";  
                        $post_types = \App\Models\PostType::orderBy('order_by')->pluck('name','id')->toArray();    

                        foreach($post_types as $k=>$v){
                            $post_type_array[$k]=$v;
                        }
                    ?>
                    <th scope="col" class="text-nowrap" style="width: 110px;">類別</th>
                    <th scope="col" class="text-nowrap" style="min-width: 250px;">標題</th>
                    <th scope="col" class="text-nowrap" style="width: 120px;">發佈者</th>
                    <th scope="col" class="text-nowrap text-center" style="width: 60px;">點閱</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td data-th="日期">
                            @if($post->top)
                                <span class="badge bg-danger me-1">置頂</span>
                            @endif
                            @if($post->inbox)
                                <span class="badge bg-warning text-dark me-1">常駐</span>
                            @endif
                            {{ substr($post->created_at,0,10) }}
                        </td>
                        <td data-th="類別">
                            @if($post->insite == null)
                                一般公告
                            @else
                                {{ $post_types[$post->insite] ?? '一般公告' }}
                            @endif
                        </td>
                        <td data-th="標題">
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
                                <a href="{{ route('posts.show_clean',$post->id) }}" class="text-decoration-none text-dark fw-bold">{!! a11y_emoji($post->title) !!}</a>
                            @else
                                <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                <span class="text-secondary">{{ $post->title }}</span>
                            @endif

                            <!-- 無障礙圖片與附件圖示標記 -->
                            @if(!empty($photos))
                                <span class="text-success ms-1" title="包含照片附件">
                                    <i class="fas fa-image" aria-hidden="true"></i>
                                    <span class="visually-hidden">(含照片附件)</span>
                                </span>
                            @endif
                            @if(!empty($files))
                                <span class="text-info ms-1" title="包含檔案附件">
                                    <i class="fas fa-download" aria-hidden="true"></i>
                                    <span class="visually-hidden">(含檔案附件)</span>
                                </span>
                            @endif
                        </td>
                        <td data-th="發佈者">
                            {{ $post->job_title }}
                        </td>
                        <td data-th="點閱" class="text-center fw-bold text-secondary">
                            {{ $post->views }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- 分頁導覽區塊 -->
        <nav aria-label="{{ $type_name }} 類別公告頁碼分頁導覽" class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </nav>
    </main>
</div>
@endsection