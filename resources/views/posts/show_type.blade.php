@extends('layouts.master_clean')

@section('title', '編輯公告類別 | ')

@section('content')
<div class="row justify-content-center my-3">
    <div class="col-md-11">
        <!-- 無障礙 HM1010301C 修正：主要頁面標題 -->
        <h1 class="h2 my-3 fw-bold">編輯公告類別與系統設定</h1>

        <!-- 類別列表管理卡片容器 -->
        <div class="card shadow-sm border mb-4">
            <div class="card-header bg-light py-3">
                <h2 class="h5 mb-0 fw-bold text-primary">
                    <i class="fas fa-list me-2" aria-hidden="true"></i> 公告類別管理
                </h2>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" aria-label="公告類別列表">
                        <caption class="visually-hidden">公告類別列表，提供新增、編輯排序、名稱、刪除與隱藏功能</caption>
                        <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 150px;">排序</th>
                            <th scope="col" style="min-width: 200px;">名稱</th>
                            <th scope="col" style="width: 250px;">動作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- 新增類別 Form -->
                        <form action="{{ route('posts.store_type') }}" method="POST" aria-label="新增公告類別表單" id="this_form1">
                            @csrf
                            <tr>
                                <td>
                                    <!-- 無障礙 HM1150100C 修正：補充專屬 ID 與隱藏 Label -->
                                    <label for="order_by_add" class="visually-hidden">新增類別排序</label>
                                    <input type="text" name="order_by" id="order_by_add" class="form-control form-control-sm" placeholder="排序" aria-label="新增類別排序">
                                </td>
                                <td>
                                    <label for="name_add" class="visually-hidden">新增類別名稱</label>
                                    <input type="text" name="name" id="name_add" class="form-control form-control-sm" required placeholder="名稱" aria-label="新增類別名稱">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="sw_confirm2('確定新增？','this_form1')">
                                        <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增
                                    </button>
                                </td>
                            </tr>
                        </form>

                        <!-- 修改既有類別 Form 列表 -->
                        @foreach($post_types as $post_type)
                        <form action="{{ route('posts.update_type', $post_type->id) }}" method="POST" aria-label="修改 {{ $post_type->name }} 類別" id="this_form2_{{ $post_type->id }}">
                            @csrf
                            @method('PATCH')
                            <tr>
                                <td>
                                    <label for="order_by_{{ $post_type->id }}" class="visually-hidden">{{ $post_type->name }} 排序</label>
                                    <input type="text" name="order_by" id="order_by_{{ $post_type->id }}" value="{{ $post_type->order_by }}" class="form-control form-control-sm" placeholder="排序" aria-label="{{ $post_type->name }} 排序">
                                </td>
                                <td>
                                    @if($post_type->id != 1 and $post_type->id != 2 and $post_type->id != 0)
                                        <label for="name_{{ $post_type->id }}" class="visually-hidden">{{ $post_type->name }} 名稱</label>
                                        <input type="text" name="name" id="name_{{ $post_type->id }}" value="{{ $post_type->name }}" class="form-control form-control-sm" required placeholder="名稱" aria-label="{{ $post_type->name }} 名稱">
                                    @else
                                        @if($post_type->id==0)
                                            <input type="hidden" name="name" value="一般公告">
                                        @endif
                                        @if($post_type->id==1)
                                            <input type="hidden" name="name" value="內部公告">
                                        @endif
                                        @if($post_type->id==2)
                                            <input type="hidden" name="name" value="榮譽榜">
                                        @endif
                                        @if($post_type->disable==1)
                                            <del class="text-muted">{{ $post_type->name }}</del>
                                        @else
                                            <span class="fw-bold">{{ $post_type->name }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm me-1" onclick="sw_confirm2('確定儲存修改？','this_form2_{{ $post_type->id }}')">儲存修改</button>
                                    
                                    @if($post_type->id != 1 and $post_type->id != 2 and $post_type->id != 0)
                                        <a href="#!" class="btn btn-danger btn-sm me-1" onclick="sw_confirm1('這類別下的所有公告將移至「一般公告」，確定刪除？','{{ route('posts.delete_type', $post_type->id) }}')" aria-label="刪除類別 {{ $post_type->name }}">刪除</a>                                     
                                    @endif

                                    @if($post_type->disable == null)
                                        <a href="#!" class="btn btn-warning btn-sm" onclick="sw_confirm1('分類公告區塊下將無此類別，確定隱藏？','{{ route('posts.disable_type', $post_type->id) }}')" aria-label="隱藏類別 {{ $post_type->name }}">隱藏</a>
                                    @else
                                        <a href="#!" class="btn btn-success btn-sm" onclick="sw_confirm1('分類公告區塊下將有此類別，確定再顯示？','{{ route('posts.disable_type', $post_type->id) }}')" aria-label="再顯示類別 {{ $post_type->name }}">再顯示</a>
                                    @endif
                                </td>
                            </tr>
                        </form>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php 
            $setup = \App\Models\Setup::first();
            $checked = ($setup->all_post) ? "checked" : null;
        ?>

        <!-- 進階公告系統設定區塊 -->
        <main aria-label="進階公告系統設定區塊">
            <!-- 預設顯示選項設定 -->
            <section class="card mb-4 shadow-sm border">
                <div class="card-header bg-light fw-bold py-3">
                    <i class="fas fa-sliders-h me-2 text-primary" aria-hidden="true"></i> 預設顯示選項設定
                </div>
                <div class="card-body">
                    <form action="{{ route('setups.all_post') }}" method="POST" id="this_form3">
                        @csrf
                        <div class="form-check mb-3">
                            <input type="checkbox" name="all_post" class="form-check-input" id="customCheck1" {{ $checked }}>
                            <label class="form-check-label" for="customCheck1">分類公告區塊中，預設顯示「全部公告」</label>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm px-3" onclick="sw_confirm2('確定？','this_form3')">確定變更</button>
                    </form>
                </div>
            </section>

            <!-- 每頁顯示筆數設定 -->
            <section class="card mb-4 shadow-sm border">
                <div class="card-header bg-light fw-bold py-3">
                    <i class="fas fa-list-ol me-2 text-primary" aria-hidden="true"></i> 每頁顯示筆數設定
                </div>
                <div class="card-body">
                    <form action="{{ route('setups.post_show_number') }}" method="POST" id="this_form4">
                        @csrf                
                        <div class="mb-3">
                            <label for="post_show_number" class="form-label fw-bold">公告的相關區塊中，一次顯示幾則？</label>
                            <div class="d-flex align-items-center">
                                <input type="number" name="post_show_number" id="post_show_number" value="{{ $setup->post_show_number }}" class="form-control form-control-sm me-2" placeholder="預設為10則" style="max-width: 200px;" aria-label="公告一次顯示幾則">
                                <button type="button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定修改？','this_form4')">修改筆數</button>
                            </div>
                        </div>
                    </form>   
                </div>
            </section>

            <!-- Line Bot 通知權杖與設定 -->
            <section class="card mb-4 shadow-sm border">
                <div class="card-header bg-light fw-bold py-3">
                    <i class="fab fa-line me-2 text-success" aria-hidden="true"></i> Line Bot 通知權杖與設定
                </div>
                <div class="card-body">
                    <form action="{{ route('setups.post_line_token') }}" method="POST" id="this_form5">
                        @csrf          
                        <fieldset>
                            <legend class="h6 fw-bold mb-2">
                                發公告時，順便使用 Line Bot 發訊息 (延後上架者無法使用)
                            </legend>
                            <p class="small text-muted mb-3">
                                參考資源：
                                <a href="{{ asset('line_bot.pdf') }}" target="_blank" rel="noopener noreferrer" class="me-2 text-decoration-none" aria-label="Line Bot 設定教學 PDF (另開新視窗)">
                                    [教學文件 <i class="fas fa-external-link-alt" aria-hidden="true"></i><span class="visually-hidden">(另開新視窗)</span>]
                                </a>
                                <a href="https://www.youtube.com/watch?v=PgYwIH2bHO0" target="_blank" rel="noopener noreferrer" class="text-decoration-none" aria-label="Line Bot 設定教學影片 (另開新視窗)">
                                    [影片教學 <i class="fas fa-external-link-alt" aria-hidden="true"></i><span class="visually-hidden">(另開新視窗)</span>]
                                </a>
                            </p>

                            <div class="mb-3">
                                <label for="post_line_bot_token" class="form-label fw-bold">Line Bot 權杖 (Token)</label>
                                <input type="text" name="post_line_bot_token" id="post_line_bot_token" value="{{ $setup->post_line_bot_token }}" class="form-control" placeholder="輸入 Line Bot 權杖" aria-label="Line Bot 權杖">
                            </div>

                            <div class="mb-3">
                                <label for="post_line_group_id" class="form-label fw-bold">Line Group 或 User ID</label>
                                <input type="text" name="post_line_group_id" id="post_line_group_id" value="{{ $setup->post_line_group_id }}" class="form-control" placeholder="輸入 Line Group 或 User ID" aria-label="Line Group 或 User ID">
                            </div>

                            <button type="button" class="btn btn-primary btn-sm px-3" onclick="sw_confirm2('確定儲存？','this_form5')">儲存 Line Bot 設定</button>
                        </fieldset>
                    </form>
                </div>
            </section>
        </main>

        @include('layouts.errors')
    </div>
</div>
@endsection