<!-- 無障礙 1.4.3 色彩對比修正 CSS (確保白底與灰底對比度均 >= 4.5:1) -->
<style>
    .text-primary-a11y {
        color: #0056b3 !important; /* 深藍色：白底對比度 7.27:1 / 灰底對比度 6.51:1 */
    }
    .post-a11y-link {
        color: #0056b3 !important;
        text-decoration: underline;
    }
    .post-a11y-link:hover, .post-a11y-link:focus {
        color: #003d82 !important;
    }
</style>

<?php
    $setup = \App\Models\Setup::first();
    $has_all_post = !empty($setup->all_post);
?>

<!-- 無障礙頁籤導覽列 (BS5 data-bs-toggle 與 data-bs-target 屬性) -->
<ul class="nav nav-tabs" id="myTab2" role="tablist" aria-label="圖文公告分類頁籤">
    @if($has_all_post)
    <li class="nav-item" role="presentation">
        <a class="nav-link active fw-bold" 
           id="post_type2_all_post-tab" 
           data-bs-toggle="tab" 
           data-bs-target="#post_type2_all_post" 
           href="#post_type2_all_post" 
           role="tab" 
           aria-controls="post_type2_all_post" 
           aria-selected="true">全部公告</a>
    </li>
    @endif
    <?php $p=1; ?>
    @foreach($post_types as $post_type)
    <?php
        $is_active = (!$has_all_post && $p === 1);
        $active_class = $is_active ? "active fw-bold" : "";    
        $aria_selected = $is_active ? "true" : "false";      
    ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $active_class }}" 
               id="post_type2_profile{{ $p }}-tab" 
               data-bs-toggle="tab" 
               data-bs-target="#post_type2_profile{{ $p }}" 
               href="#post_type2_profile{{ $p }}" 
               role="tab" 
               aria-controls="post_type2_profile{{ $p }}" 
               aria-selected="{{ $aria_selected }}">{{ $post_type->name }}</a>
        </li>
        <?php $p++; ?>
    @endforeach
</ul>

<!-- 頁籤內容區塊 -->
<div class="tab-content" id="myTabContent2">
    @if($has_all_post)
    <div class="tab-pane fade show active p-2" id="post_type2_all_post" role="tabpanel" aria-labelledby="post_type2_all_post-tab">
        @auth
            @can('create', \App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm mb-2">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增公告
                </a>
            @else
                <?php 
                    $users = \App\Models\User::where('admin',1)->whereNull('disable')->get();
                    $user_name = '';
                    foreach($users as $user){
                        $user_name .= $user->title ." ".$user->name.'\n\r';
                    }
                    $msg = '請\n\r'.$user_name.'加你進去校網行政人員群組';
                ?>
                <button type="button" class="btn btn-success btn-sm mb-2" onclick="alert('{{ $msg }}')">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 我想公告
                </button>
            @endcan
        @endauth

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" style="word-break: break-all;" aria-label="全部圖文公告列表">
                <caption class="visually-hidden">全部圖文公告表格列表</caption>
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap" style="width: 110px;">日期</th>
                        <th scope="col" class="text-nowrap" style="width: 100px;">類別</th>
                        <th scope="col" class="text-nowrap" style="min-width: 300px;">公告內容</th>
                        <th scope="col" class="text-nowrap" style="width: 120px;">發佈者</th>
                        <th scope="col" class="text-nowrap text-center" style="width: 80px;">點閱</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <?php
                    if($post->insite==1){
                        $can_see = (auth()->check() or check_ip()) ? 1 : 0;
                    }else{
                        $can_see = 1;
                    };
                    $school_code = school_code();                            
                    $files = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/files'));
                    $photos = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/photos'));
                    $insite = ($post->insite != null)?$post->insite:0;

                    $content = str_limit(strip_tags($post->content),'150');
                    $content = str_replace('&nbsp;','',$content);
                    ?>
                    <tr>
                        <td>{{ substr($post->created_at,0,10) }}</td>
                        <td>{{ $post_type_array[$insite] }}</td>
                        
                        <!-- 整合「圖片 + 標題 + 摘要」至單一超連結 -->
                        <td>
                            <div class="py-1">
                                @if($can_see)
                                    <a href="{{ route('posts.show',$post->id) }}" class="d-flex align-items-start text-decoration-none text-dark w-100" title="查看公告：{{ $post->title }}" aria-label="查看公告：{{ $post->title }}">
                                        @if($post->title_image)
                                            <div class="me-3 flex-shrink-0" style="width: 90px;">
                                                <img src="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/title_image.png') }}" class="img-fluid rounded border shadow-sm" style="object-fit: cover; height: 60px; width: 100%;" alt="" aria-hidden="true">
                                            </div>
                                        @endif

                                        <div class="flex-grow-1">
                                            <div style="font-size: 1.1rem;" class="mb-1">
                                                @if($post->top)
                                                    <span class="badge bg-danger me-1">置頂</span>
                                                @endif
                                                @if($post->inbox)
                                                    <span class="badge bg-warning text-dark me-1">常駐</span>
                                                @endif
                                                @if($post->insite==1)
                                                    <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                                @endif
                                                <!-- 改用 text-primary-a11y 高對比藍色 -->
                                                <span class="fw-bold text-primary-a11y">{!! a11y_emoji($post->title) !!}</span>

                                                @if(!empty($photos))
                                                    <span class="text-success ms-1">
                                                        <i class="fas fa-image" aria-hidden="true"></i>
                                                        <span class="visually-hidden">（含圖片附件）</span>
                                                    </span>
                                                @endif
                                                @if(!empty($files))
                                                    <span class="text-info ms-1">
                                                        <i class="fas fa-download" aria-hidden="true"></i>
                                                        <span class="visually-hidden">（含檔案下載）</span>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="mb-0 text-secondary small">
                                                {{ $content }}
                                            </p>
                                        </div>
                                    </a>
                                @else
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <div style="font-size: 1.1rem;" class="mb-1">
                                                <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                                <span class="fw-bold text-secondary">{{ $post->title }}</span>
                                            </div>
                                            <p class="mb-0 text-secondary small">
                                                <span class="text-muted">請登入後再查看完整內容</span>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td>
                            <!-- 發佈者超連結改用 post-a11y-link 確保對比度 -->
                            <a href="{{ route('posts.job_title',$post->job_title) }}" class="post-a11y-link fw-bold">{{ $post->job_title }}</a>
                        </td>
                        <td class="text-center fw-bold text-secondary">{{ $post->views }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-2">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm" style="color: #0056b3; border-color: #0056b3;">
                <i class="far fa-hand-point-up me-1" aria-hidden="true"></i> 查看更多公告...
            </a>
        </div>
    </div>
    @endif

    <?php $p=1; ?>
    @foreach($post_types as $post_type)
    <?php 
        $is_active_pane = (!$has_all_post && $p === 1);
        $active_pane_class = $is_active_pane ? "show active" : "";
    ?>
        <div class="tab-pane fade {{ $active_pane_class }} p-2" id="post_type2_profile{{ $p }}" role="tabpanel" aria-labelledby="post_type2_profile{{ $p }}-tab">
            <?php
            $p++;
            $insite = ($post_type->id == 0)?null:$post_type->id;
            $posts = \App\Models\Post::where('insite',$insite)
                ->where(function ($query) {
                    $query->where('die_date',null)->orWhere('die_date','>=',date('Y-m-d'));
                })->where('created_at','<',date('Y-m-d H:i:s'))->orderBy('top','DESC')
                ->orderBy('created_at','DESC')
                ->paginate($post_show_number);

            foreach($posts as $post){
                if($post->top ==1){
                    if($post->top_date < date('Y-m-d')){
                        $att['top'] = null;
                        $att['top_date'] = null;
                        $post->update($att);
                    }    
                }
            }
            ?>
            @auth
                @can('create', \App\Models\Post::class)
                    <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm mb-2">
                        <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增公告
                    </a>
                @endcan
            @endauth

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0" style="word-break: break-all;" aria-label="{{ $post_type->name }} 圖文公告列表">
                    <caption class="visually-hidden">{{ $post_type->name }} 分類圖文公告表格列表</caption>
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-nowrap" style="width: 110px;">日期</th>
                            <th scope="col" class="text-nowrap" style="width: 100px;">類別</th>
                            <th scope="col" class="text-nowrap" style="min-width: 300px;">公告內容</th>
                            <th scope="col" class="text-nowrap" style="width: 120px;">發佈者</th>
                            <th scope="col" class="text-nowrap text-center" style="width: 80px;">點閱</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <?php
                        if($post->insite==1){
                            $can_see = (auth()->check() or check_ip()) ? 1 : 0;
                        }else{
                            $can_see = 1;
                        };
                        $school_code = school_code();                                
                        $files = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/files'));
                        $photos = get_files(storage_path('app/public/'.$school_code.'/posts/'.$post->id.'/photos'));

                        $content = str_limit(strip_tags($post->content),'150');
                        $content = str_replace('&nbsp;','',$content);
                        ?>
                        <tr>
                            <td>{{ substr($post->created_at,0,10) }}</td>
                            <td>{{ $post_type->name }}</td>

                            <!-- 整合「圖片 + 標題 + 摘要」至單一超連結 -->
                            <td>
                                <div class="py-1">
                                    @if($can_see)
                                        <a href="{{ route('posts.show',$post->id) }}" class="d-flex align-items-start text-decoration-none text-dark w-100" title="查看公告：{{ $post->title }}" aria-label="查看公告：{{ $post->title }}">
                                            @if($post->title_image)
                                                <div class="me-3 flex-shrink-0" style="width: 90px;">
                                                    <img src="{{ asset('storage/'.$school_code.'/posts/'.$post->id.'/title_image.png') }}" class="img-fluid rounded border shadow-sm" style="object-fit: cover; height: 60px; width: 100%;" alt="" aria-hidden="true">
                                                </div>
                                            @endif

                                            <div class="flex-grow-1">
                                                <div style="font-size: 1.1rem;" class="mb-1">
                                                    @if($post->top)
                                                        <span class="badge bg-danger me-1">置頂</span>
                                                    @endif
                                                    @if($post->inbox)
                                                        <span class="badge bg-warning text-dark me-1">常駐</span>
                                                    @endif
                                                    @if($can_see)
                                                        @if($post->insite==1)
                                                            <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                                        @endif
                                                        <!-- 改用 text-primary-a11y 高對比藍色 -->
                                                        <span class="fw-bold text-primary-a11y">{!! a11y_emoji($post->title) !!}</span>
                                                    @else
                                                        <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                                        <span class="fw-bold">{{ $post->title }}</span>
                                                    @endif

                                                    @if(!empty($photos))
                                                        <span class="text-success ms-1">
                                                            <i class="fas fa-image" aria-hidden="true"></i>
                                                            <span class="visually-hidden">（含圖片附件）</span>
                                                        </span>
                                                    @endif
                                                    @if(!empty($files))
                                                        <span class="text-info ms-1">
                                                            <i class="fas fa-download" aria-hidden="true"></i>
                                                            <span class="visually-hidden">（含檔案下載）</span>
                                                        </span>
                                                    @endif
                                                </div>

                                                <p class="mb-0 text-secondary small">
                                                    @if($can_see)
                                                        {{ $content }}
                                                    @else
                                                        <span class="text-muted">請登入後再查看完整內容</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <div style="font-size: 1.1rem;" class="mb-1">
                                                    <span class="text-danger fw-bold me-1">[ 內部公告 ]</span>
                                                    <span class="fw-bold text-secondary">{{ $post->title }}</span>
                                                </div>
                                                <p class="mb-0 text-secondary small">
                                                    <span class="text-muted">請登入後再查看完整內容</span>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <!-- 發佈者超連結改用 post-a11y-link 確保對比度 -->
                                <a href="{{ route('posts.job_title',$post->job_title) }}" class="post-a11y-link fw-bold">{{ $post->job_title }}</a>
                            </td>
                            <td class="text-center fw-bold text-secondary">{{ $post->views }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>            
            <div class="mt-2">
                <a href="{{ route('posts.type',$post_type->id) }}" class="btn btn-outline-primary btn-sm" style="color: #0056b3; border-color: #0056b3;">
                    <i class="far fa-hand-point-up me-1" aria-hidden="true"></i> 查看更多 {{ $post_type->name }}...
                </a>
            </div>
        </div>
    @endforeach
</div>