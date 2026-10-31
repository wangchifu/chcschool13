<?php
    if(!isset($type_name)) $type_name=null;
    $key = rand(100,999);
    session(['search' => $key]);    
    $post_types = \App\Models\PostType::orderBy('order_by')->get();    

    foreach($post_types as $post_type){
      $post_type_array[$post_type->id]=$post_type->name;
    }
?>

<!-- 頂部操作工具列：採用 Flexbox 與 Bootstrap 5 gap 彈性間距 -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <!-- 類別選擇與管理按鈕區塊 -->
    <div class="d-flex flex-wrap align-items-center gap-2">
        <form id="select_type_form" action="{{ route('posts.select_type') }}" method="POST" class="d-inline-block">
            @csrf
            <!-- 無障礙：隱藏標籤 -->
            <label for="select_type" class="visually-hidden">選擇公告類別</label>
            <select id="select_type" name="select_type" class="form-select form-select-sm" title="選擇公告類別" aria-label="選擇公告類別">
                <option value="a">請選類別</option>
                @foreach($post_types as $post_type)
                    @if($post_type->disable != 1)
                        <?php $selected = ($post_type->name == $type_name) ? "selected" : null; ?>
                        <option value="{{ $post_type->id }}" {{ $selected }}>{{ $post_type->name }}</option>
                    @endif
                @endforeach
            </select>
        </form>

        @auth            
            @can('create', \App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增公告
                </a>
            @else                
                <?php 
                    $users = \App\Models\User::where('admin', 1)->whereNull('disable')->get();
                    $user_name = '';
                    foreach($users as $user){
                        $user_name .= $user->title ." ".$user->name.'\n\r';
                    }
                    $msg = '請\n\r'.$user_name.'加你進去校網行政人員群組';
                ?>
                <button type="button" class="btn btn-success btn-sm" onclick="alert('{{ $msg }}')">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 我想公告
                </button>
            @endcan

            @if(auth()->user()->admin == 1)
                <a href="{{ route('posts.show_type') }}" class="btn btn-success btn-sm venobox" data-vbtype="iframe" aria-label="開啟類別管理新視窗">
                    <i class="fas fa-cog me-1" aria-hidden="true"></i> 類別管理
                </a>
            @endif
        @endauth
    </div>

    <!-- 關鍵字搜尋區塊 -->
    <div>
        <form action="{{ route('posts.search') }}" method="POST" class="d-flex flex-wrap align-items-center gap-2" id="this_form">
            @csrf
            
            <label for="search" class="visually-hidden">關鍵字搜尋</label>
            <input type="text" class="form-control form-control-sm" name="search" id="search" title="請輸入要搜尋公告的關鍵字" placeholder="關鍵字" aria-label="請輸入要搜尋公告的關鍵字" required style="width:130px;">

            <label for="check_code" class="visually-hidden">驗證碼，請輸入 {{ session('search') }}</label>
            <input type="text" class="form-control form-control-sm" name="check" id="check_code" title="請輸入驗證碼" placeholder="驗證碼: {{ session('search') }}" aria-label="請輸入驗證碼 {{ session('search') }}" required maxlength="3" style="width:110px;">

            <button type="submit" class="btn btn-secondary btn-sm" aria-label="提交搜尋公告">
                <i class="fas fa-search me-1" aria-hidden="true"></i> 搜尋
            </button>
        </form>
    </div>
</div>

@include('layouts.errors')

<div class="table-responsive">
    <!-- 公告列表表格 -->
    <table class="table table-striped table-hover align-middle mb-0" style="word-break:break-all;" aria-label="公告列表">
        <caption class="visually-hidden">公告訊息列表</caption>
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
                <td scope="row">                    
                    {{ substr($post->created_at,0,10) }}
                </td>
                <td>
                    @if($post->insite == null)
                        <a href="{{ route('posts.type',0) }}" class="text-decoration-none fw-bold">一般公告</a>
                    @else
                        <a href="{{ route('posts.type',$post->insite) }}" class="text-decoration-none fw-bold">{{ $post_type_array[$post->insite] }}</a>
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
                        <a href="{{ route('posts.show',$post->id) }}" class="text-decoration-none text-dark fw-bold">{!! a11y_emoji($post->title) !!}</a>
                    @else
                        <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                        <span class="text-secondary">{{ $post->title }}</span>
                    @endif

                    <!-- 無障礙圖片與檔案圖示標示 -->
                    @if(!empty($photos))
                        <span class="text-success ms-1" title="包含照片附件" aria-label="包含照片附件">
                            <i class="fas fa-image" aria-hidden="true"></i>
                            <span class="visually-hidden">（包含照片附件）</span>
                        </span>
                    @endif
                    @if(!empty($files))
                        <span class="text-info ms-1" title="包含檔案下載" aria-label="包含檔案下載">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            <span class="visually-hidden">（包含檔案下載）</span>
                        </span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('posts.job_title',$post->job_title) }}" class="text-decoration-none text-secondary">{{ $post->job_title }}</a>
                </td>
                <td class="text-center fw-bold text-secondary">
                    {{ $post->views }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>    
    $('#select_type').change(function(){
      if($('#select_type').val() != 'a'){        
        $('#select_type_form').submit();
      }
    });
</script>