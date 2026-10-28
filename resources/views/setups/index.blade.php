@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '網站設定 | ')

@section('in_head_css')
    <style type="text/css">
        /* 修正 BS5 input-group 內調色盤按鈕被平分拉長的問題 */
        .form-control-color {
            width: 45px !important;
            flex: 0 0 45px !important; /* 固定寬度，不跟文字框平分剩餘空間 */
            padding: 0.25rem !important;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')            
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1>網站設定</h1>

            <?php
            $active[1] = "active";
            $active[2] = "";
            $active[3] = "";
            $active[4] = "";
            $active[5] = "";
            $active[6] = "";
            $active[7] = "";
            $nav_color = explode(',',$setup->nav_color);
            $c1 = (empty($nav_color[0]))?"#DD0F20":$nav_color[0];
            $c2 = (empty($nav_color[1]))?"#F18A31":$nav_color[1];
            $c3 = (empty($nav_color[2]))?"#F8EB48":$nav_color[2];
            $c4 = (empty($nav_color[3]))?"#16813D":$nav_color[3];
            $c5 = (empty($setup->bg_color))?"#f0f1f6":$setup->bg_color;            
            ?>
            @include('setups.nav',$active)

            <!-- 頂部標題區 -->
            <div class="d-flex justify-content-between align-items-center my-3">
                <h3 class="m-0">基本設定與導覽列配置</h3>
            </div>

            <!-- 1. 基本設定卡片 -->
            <div class="card my-3 shadow-sm">
                <div class="card-header bg-light text-dark fw-bold">
                    <i class="fas fa-cog me-1"></i> 網站基本資訊與設定
                </div>
                <div class="card-body bg-light">
                    @include('layouts.errors')
                    
                    <form action="{{ route('setups.text', $setup->id) }}" method="POST" id="this_form1">
                        @csrf
                        @method('PATCH')
                    
                        <!-- 區塊：基本資訊 -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body bg-white rounded">
                                <h5 class="card-title fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-info-circle me-1"></i> 基本資料與外觀
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="site_name" class="fw-bold form-label">網站名稱</label>
                                        <input type="text" name="site_name" id="site_name" value="{{ $setup->site_name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="views" class="fw-bold form-label">累積總瀏覽人數</label>
                                        <input type="text" name="views" id="views" value="{{ $setup->views }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="nav_bg_color" class="fw-bold form-label">網頁背景色</label>
                                        <small class="text-muted">(<a href="https://www.toolskk.com/color" target="_blank">色碼表</a>)</small>
                                        <div class="input-group">
                                            <input type="text" class="form-control color-text-input" value="{{ $c5 }}" id="nav_bg_color" name="bg_color" maxlength="7">
                                            <input type="color" class="form-control form-control-color" value="{{ $c5 }}" title="點擊選擇色彩">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 區塊：校園 IP 範圍 -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body bg-white rounded">
                                <h5 class="card-title fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-network-wired me-1"></i> 學校真實 IP 範圍設定
                                    <small class="text-muted ms-2 fw-normal">
                                        [<a href="{{ asset('ipv4.xlsx') }}" target="_blank"><i class="far fa-file-excel me-1"></i>IPv4參考文件</a>]
                                        [<a href="{{ asset('ipv6.xlsx') }}" target="_blank"><i class="far fa-file-excel me-1"></i>IPv6參考文件</a>]
                                    </small>
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="fw-bold mb-1 form-label">IPv4 網段範圍：</label>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted">從</span>
                                            <input type="text" name="ip1" value="{{ $setup->ip1 }}" class="form-control me-2" placeholder="163.23.xxx.xxx">
                                            <span class="me-2 text-muted">到</span>
                                            <input type="text" name="ip2" value="{{ $setup->ip2 }}" class="form-control" placeholder="163.23.xxx.xxx">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-0">
                                        <label for="ipv6" class="fw-bold mb-1 form-label">IPv6 網段範圍：</label>
                                        <input type="text" name="ipv6" id="ipv6" value="{{ $setup->ipv6 }}" class="form-control" placeholder="如：2001:288:5637::/48">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 區塊：頁尾 Footer -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body bg-white rounded">
                                <h5 class="card-title fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-shoe-prints me-1"></i> 頁尾內容 (Footer)
                                </h5>
                                <div class="mb-3">
                                    <label for="footer" class="fw-bold form-label">置底自訂內容 (id="footer")</label>
                                    <textarea name="footer" id="tiny_editor" class="form-control">{{ $setup->footer }}</textarea>
                                </div>

                                <?php 
                                    $disable_right = ($setup->disable_right)?"checked":"";
                                    $r1 = (empty($setup->close_website))?"checked":"";
                                    $r2 = (empty($setup->close_website))?"":"checked";
                                ?>
                                <div class="border p-3 rounded bg-light mb-0">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="disable_right" name="disable_right" {{ $disable_right }} value="1">
                                        <label class="form-check-label fw-bold text-dark" for="disable_right">
                                            隱藏版權列 (id="footer_bottom")
                                        </label>
                                    </div>
                                    <div class="small text-muted mb-2">預設版權列真實呈現樣式：</div>
                                        <div class="footer-copyright text-center py-3 bg-dark text-white border-top border-secondary" id="footer_bottom">
                                            <div class="container-fluid px-3">
                                                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                                                    
                                                    <div class="fw-semibold small">
                                                        &copy; {{ date('Y') }} 
                                                        <a href="{{ route('index','index') }}" class="text-white fw-bold text-decoration-underline">
                                                            {{ $setup->site_name }}
                                                        </a> 
                                                        <span class="mx-1">All Rights Reserved.</span>
                                                    </div>

                                                    <span class="d-none d-md-inline opacity-50" aria-hidden="true">|</span>

                                                    <div class="d-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill border border-secondary text-white">
                                                        <i class="fas fa-chart-line text-warning me-2" aria-hidden="true"></i>
                                                        <span class="small fw-bold">訪客人次：</span>
                                                        <span class="fw-bold">{{ number_format($setup->views) }}</span>
                                                    </div>

                                                    <div class="d-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill border border-secondary text-white">
                                                        <i class="fas fa-network-wired text-info me-2" aria-hidden="true"></i>
                                                        <span class="small fw-bold">您的 IP：</span>
                                                        <span class="fw-bold">{{ GetIP() }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>  
                                </div>
                            </div>
                        </div>

                        <!-- 區塊：網站維護開關 -->
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body bg-white rounded">
                                <h5 class="card-title fw-bold text-primary border-bottom pb-2">
                                    <i class="fas fa-power-off me-1"></i> 網站開放狀態與維護設定
                                </h5>
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <div class="form-check mb-2">
                                            <input type="radio" class="form-check-input" id="site_open" name="set_close_website" value="on" {{ $r1 }}>
                                            <label class="form-check-label text-success fw-bold" for="site_open">
                                                <i class="fas fa-check-circle me-1"></i> 網站正常開放
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="site_close" name="set_close_website" value="off" {{ $r2 }}>
                                            <label class="form-check-label text-danger fw-bold" for="site_close">
                                                <i class="fas fa-times-circle me-1"></i> 暫停服務 (關閉網站)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="close_website" class="fw-bold mb-1 form-label">關閉網站原因公告：</label>
                                        <input type="text" name="close_website" id="close_website" value="{{ $setup->close_website }}" class="form-control" placeholder="如：系統例行維護中，預計今日18:00恢復開放">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 儲存基本設定按鈕 -->
                        <div class="text-end">
                            <button type="button" class="btn btn-primary px-4" onclick="sw_confirm2('確定儲存基本設定？','this_form1')">
                                <i class="fas fa-save me-1"></i> 儲存基本設定
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. 導覽列設定卡片 -->
            <form action="{{ route('setups.nav_color', $setup->id) }}" method="POST" id="this_form2">
                @csrf
                @method('PATCH')
                <div class="card my-4 shadow-sm">
                    <div class="card-header bg-light text-dark fw-bold">
                        <i class="fas fa-compass me-1"></i> 上方導覽列與選單設定
                    </div>
                    <div class="card-body bg-light">
                        
                        <!-- 導覽列顏色與浮動 -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body bg-white rounded">
                                <h5 class="card-title fw-bold text-primary border-bottom pb-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-palette me-1"></i> 導覽列外觀與色彩對比</span>
                                    <small class="text-muted fw-normal">(<a href="https://www.toolskk.com/color" target="_blank"><i class="fas fa-external-link-alt me-1"></i>線上色碼表</a>)</small>
                                </h5>

                                <?php 
                                    $checked = ($setup->fixed_nav)?"checked":null;
                                ?>
                                <div class="form-check mb-3 p-2 ps-5 bg-light border rounded">
                                    <input type="checkbox" name="fixed_nav" class="form-check-input" id="customCheck1" {{ $checked }}>
                                    <label class="form-check-label fw-bold text-dark" for="customCheck1">
                                        <i class="fas fa-thumbtack me-1 text-info"></i> 固定於頁面頂端 (Fixed Navbar)
                                    </label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nav_color1" class="fw-bold form-label">導覽列背景顏色</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control color-text-input" value="{{ $c1 }}" id="nav_color1" name="color[]" maxlength="7">
                                            <input type="color" class="form-control form-control-color" value="{{ $c1 }}" title="點擊選擇色彩">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nav_color2" class="fw-bold form-label">網站名稱文字顏色</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control color-text-input" value="{{ $c2 }}" id="nav_color2" name="color[]" maxlength="7">
                                            <input type="color" class="form-control form-control-color" value="{{ $c2 }}" title="點擊選擇色彩">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="nav_color3" class="fw-bold form-label">選單連結文字顏色</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control color-text-input" value="{{ $c3 }}" id="nav_color3" name="color[]" maxlength="7">
                                            <input type="color" class="form-control form-control-color" value="{{ $c3 }}" title="點擊選擇色彩">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-0">
                                        <label for="nav_color4" class="fw-bold form-label">選單連結移上時 (Hover) 顏色</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control color-text-input" value="{{ $c4 }}" id="nav_color4" name="color[]" maxlength="7">
                                            <input type="color" class="form-control form-control-color" value="{{ $c4 }}" title="點擊選擇色彩">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 系統按鈕改名 -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body bg-white rounded p-0">
                                <div class="p-3 border-bottom">
                                    <h5 class="card-title fw-bold text-primary m-0">
                                        <i class="fas fa-edit me-1"></i> 預設系統功能按鈕自訂名稱
                                    </h5>
                                </div>
                                <div class="p-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle mb-0">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th style="width: 14%;">首頁</th>
                                                    <th style="width: 14%;">公告系統</th>
                                                    <th style="width: 14%;">檔案庫</th>
                                                    <th style="width: 14%;">學校介紹</th>
                                                    <th style="width: 14%;">校務行政</th>
                                                    <th style="width: 14%;">系統設定</th>
                                                    <th style="width: 14%;">登入</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="homepage_name" value="{{ $setup->homepage_name }}" class="form-control form-control-sm text-center" placeholder="首頁">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="post_name" value="{{ $setup->post_name }}" class="form-control form-control-sm text-center" placeholder="公告系統">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="openfile_name" value="{{ $setup->openfile_name }}" class="form-control form-control-sm text-center" placeholder="檔案庫">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="department_name" value="{{ $setup->department_name }}" class="form-control form-control-sm text-center" placeholder="學校介紹">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="schoolexec_name" value="{{ $setup->schoolexec_name }}" class="form-control form-control-sm text-center" placeholder="校務行政">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="setup_name" value="{{ $setup->setup_name }}" class="form-control form-control-sm text-center" placeholder="系統設定">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="login_name" value="{{ $setup->login_name }}" class="form-control form-control-sm text-center" placeholder="登入">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                                    <a href="#!" class="btn btn-outline-danger btn-sm" id="default_color" onclick="sw_confirm1('確定要將導覽列還原為預設顏色嗎？','{{ route('setups.nav_default') }}')">
                                        <i class="fas fa-undo me-1"></i> 還原導覽列預設值
                                    </a>
                                    <button type="button" class="btn btn-primary px-4" onclick="sw_confirm2('確定儲存導覽列設定？','this_form2')">
                                        <i class="fas fa-save me-1"></i> 儲存導覽列設定
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>    
@endsection

@section('at_bottom_js')    
    <script src="https://cdn.tiny.cloud/1/t3x62bustao4bqhd7m12sm2o54zuql6jdimapxaxkwc0swtb/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script src="{{ asset('js/tinymce.js') }}"></script>
    <script>
        $(function () {
            // 點擊原生調色盤：即時同步顏色 HEX 代碼至左側文字輸入框
            $('.form-control-color').on('input change', function () {
                $(this).siblings('.color-text-input').val($(this).val());
            });

            // 手動輸入 HEX 代碼：同步更新右側調色盤圖示
            $('.color-text-input').on('input change', function () {
                var val = $(this).val();
                if (/^#[0-9A-F]{6}$/i.test(val)) {
                    $(this).siblings('.form-control-color').val(val);
                }
            });
            
        });


    </script>
@endsection