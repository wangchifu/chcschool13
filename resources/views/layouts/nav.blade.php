<?php $module_setup = get_module_setup(); ?>
<?php        
    $fixed_top = ($setup->fixed_nav)?"fixed-top ":null;
?>

<!-- 全局手機端導覽列排版修補 -->
<style>
    @media (max-width: 991.98px) {
        .navbar {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0.5rem 0.75rem !important;
        }

        .navbar-brand {
            font-size: 1.05rem !important;
            font-weight: bold;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: calc(100% - 60px) !important;
            margin-right: 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        .navbar-brand img {
            width: 30px !important;
            height: 30px !important;
            margin-right: 6px !important;
            flex-shrink: 0;
        }

        .navbar-toggler {
            padding: 5px 10px !important;
            font-size: 1.25rem !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            border-radius: 6px !important;
            color: inherit !important;
            box-shadow: none !important;
            outline: none !important;
            flex-shrink: 0 !important;
        }

        .navbar-toggler:focus, .navbar-toggler:hover {
            background-color: rgba(255, 255, 255, 0.35) !important;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5) !important;
        }
    }
</style>

@if($nav_color == 'navbar-custom' && isset($navbar_custom[0]))
<style>
    .navbar-custom {
        background-color: {{ $navbar_custom[0] }} !important;
        --nav-brand-color: {{ $navbar_custom[1] }};
        --nav-link-color: {{ $navbar_custom[2] }};
        --nav-hover-color: {{ $navbar_custom[3] }};
    }
</style>
@endif

<nav class="navbar navbar-expand-lg {{ $nav_color }} {{ $fixed_top }}" id="mainNav" role="navigation" aria-label="主要選單導覽">
    <div class="container-fluid">        
        <a class="navbar-brand js-scroll-trigger d-inline-flex align-items-center" href="{{ route('index') }}" title="返回首頁 - {{ $setup->site_name }}">
            @if(file_exists(storage_path('app/public/'.$school_code.'/title_image/logo.ico')))
                <img src="{{ asset('storage/'.$school_code.'/title_image/logo.ico') }}" width="30" height="30" class="me-2" alt="{{ $setup->site_name }}標誌">
            @else
                <img src="{{ asset('images/site_logo.png') }}" width="30" height="30" class="me-2" alt="{{ $setup->site_name }}標誌">
            @endif
            <span style="white-space: nowrap;" aria-hidden="true">{{ $setup->site_name }}</span>
        </a>        
        
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="切換導覽選單顯示">
            <span class="navbar-toggler-icon" aria-hidden="true"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                {{-- 1. 首頁 --}}
                @if(isset($module_setup['首頁']))
                    <li class="nav-item @yield('nav_home_active')">
                        <?php 
                            $homepage_name = ($setup->homepage_name)?$setup->homepage_name:"首頁"; 
                            $is_home_active = (trim($__env->yieldContent('nav_home_active')) == 'active');
                        ?>
                        <a class="nav-link @if($is_home_active) active @endif" href="{{ route('index') }}" @if($is_home_active) aria-current="page" @endif title="前往首頁">
                            {{ $homepage_name }}
                            @if($is_home_active) <span class="visually-hidden">(目前頁面)</span> @endif
                        </a>
                    </li>
                @endif
                @if(isset($module_setup['導覽']))
                    <li class="nav-item @yield('nav_sitemap_active')">
                        <?php $is_sitemap_active = (trim($__env->yieldContent('nav_sitemap_active')) == 'active'); ?>
                        <a class="nav-link @if($is_sitemap_active) active @endif" href="{{ route('sitemap') }}" @if($is_sitemap_active) aria-current="page" @endif title="網站導覽" aria-label="網站導覽">
                            <i class="fas fa-sitemap" aria-hidden="true"></i>
                            <span>網站導覽</span>
                            @if($is_sitemap_active) <span class="visually-hidden">(目前頁面)</span> @endif
                        </a>
                    </li>
                @endif

                @if(isset($module_setup['公告系統']))
                    <li class="nav-item @yield('nav_post_active')">
                        <?php 
                            $post_name = ($setup->post_name)?$setup->post_name:"公告系統"; 
                            $is_post_active = (trim($__env->yieldContent('nav_post_active')) == 'active');
                        ?>
                        <a class="nav-link @if($is_post_active) active @endif" href="{{ route('posts.index') }}" @if($is_post_active) aria-current="page" @endif>
                            {{ $post_name }}
                            @if($is_post_active) <span class="visually-hidden">(目前頁面)</span> @endif
                        </a>
                    </li>
                @endif
                @if(isset($module_setup['檔案庫']))
                    <li class="nav-item @yield('nav_open_files_active')">
                        <?php 
                            $openfile_name = ($setup->openfile_name)?$setup->openfile_name:"檔案庫"; 
                            $is_files_active = (trim($__env->yieldContent('nav_open_files_active')) == 'active');
                        ?>
                        <a class="nav-link @if($is_files_active) active @endif" href="{{ route('open_files.index') }}" @if($is_files_active) aria-current="page" @endif>
                            {{ $openfile_name }}
                            @if($is_files_active) <span class="visually-hidden">(目前頁面)</span> @endif
                        </a>
                    </li>
                @endif
                @if(isset($module_setup['學校介紹']))
                    <li class="nav-item dropdown @yield('nav_departments_active')">
                        <?php $department_name = ($setup->department_name)?$setup->department_name:"學校介紹"; ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkDepartments" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            {{ $department_name }}
                        </a>
                        <?php $departments = \App\Models\Department::orderBy('order_by')->get(); ?>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLinkDepartments">
                            @if(!empty($departments) && is_iterable($departments))
                                @foreach($departments as $department)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('departments.show',$department->id) }}">
                                            <i class="fas fa-puzzle-piece" aria-hidden="true"></i> {{ $department->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif
                @if(isset($module_setup['選單連結']))
                    <?php 
                        $types = \App\Models\Type::where('type_id',null)->orderBy('order_by')->get();
                        $type2s = \App\Models\Type::where('type_id','<>',null)->orderBy('order_by')->get();
                        $links = \App\Models\Link::orderBy('order_by')->get();
                        $type2_data = [];
                        foreach($type2s as $type2){
                            $type2_data[$type2->type_id][$type2->id]['name'] = $type2->name;
                        }
                        
                        $link_data = [];
                        foreach($links as $link){
                            $link_data[$link->type_id][$link->id]['target'] = $link->target;
                            $link_data[$link->type_id][$link->id]['url'] = $link->url;
                            $link_data[$link->type_id][$link->id]['icon'] = $link->icon;
                            $link_data[$link->type_id][$link->id]['name'] = $link->name;
                        }
                    ?>
                    @if(!empty($types) && is_iterable($types))
                        @foreach($types as $type)
                           <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#!" id="navbarDropdownMenuLink_{{ $type->id }}" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    {{ $type->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink_{{ $type->id }}">
                                    @if(isset($type2_data[$type->id]) && is_iterable($type2_data[$type->id]))
                                        @foreach($type2_data[$type->id] as $k => $v)
                                        <li>
                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                <i class="fas fa-folder" aria-hidden="true"></i> {{ $v['name'] }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if(isset($link_data[$k]) && is_iterable($link_data[$k]))
                                                    @foreach($link_data[$k] as $k2 => $v2)
                                                    <?php
                                                        if($v2['target'] == null) $target = "_blank";
                                                        if($v2['target'] == "_self") $target = "_self";
                                                    ?>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ $v2['url'] }}" target="{{ $target }}" @if($target == '_blank') title="{{ $v2['name'] }} (另開新視窗)" @endif>
                                                                @if($v2['icon']==null)
                                                                <i class="fas fa-globe" aria-hidden="true"></i>
                                                                @else
                                                                <i class="{{ $v2['icon'] }}" aria-hidden="true"></i>
                                                                @endif
                                                                {{ $v2['name'] }}
                                                                @if($v2['target'] == null)
                                                                <i class="fas fa-level-up-alt" aria-hidden="true"></i>
                                                                <span class="visually-hidden">(另開新視窗)</span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                        @endforeach
                                    @endif
                                    @if(isset($link_data[$type->id]) && is_iterable($link_data[$type->id]))
                                        @foreach($link_data[$type->id] as $k => $v)
                                            <?php
                                                if($v['target'] == null) $target = "_blank";
                                                if($v['target'] == "_self") $target = "_self";
                                            ?>
                                            <li>
                                                <a class="dropdown-item" href="{{ $v['url'] }}" target="{{ $target }}" @if($target == '_blank') title="{{ $v['name'] }} (另開新視窗)" @endif>
                                                    @if($v['icon']==null)
                                                    <i class="fas fa-globe" aria-hidden="true"></i>
                                                    @else
                                                    <i class="{{ $v['icon'] }}" aria-hidden="true"></i>
                                                    @endif
                                                    {{ $v['name'] }}
                                                    @if($v['target'] == null)
                                                    <i class="fas fa-level-up-alt" aria-hidden="true"></i>
                                                    <span class="visually-hidden">(另開新視窗)</span>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @endif
                @endif

                @auth
                    @if(isset($module_setup['校務行政']))
                        <li class="nav-item dropdown @yield('nav_school_active')">
                            <?php $schoolexec_name = ($setup->schoolexec_name)?$setup->schoolexec_name:"校務行政"; ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkSchoolExec" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                {{ $schoolexec_name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLinkSchoolExec">
                                @if(isset($module_setup['校務行事曆']))
                                    <li><a class="dropdown-item" href="{{ route('calendars.index') }}"><i class="fas fa-calendar" aria-hidden="true"></i> 校務行事曆</a></li>
                                @endif
                                @if(isset($module_setup['校務月曆']))
                                    <li><a class="dropdown-item" href="{{ route('monthly_calendars.index') }}"><i class="fas fa-calendar-alt" aria-hidden="true"></i> 校務月曆</a></li>
                                @endif
                                @if(isset($module_setup['內部文件']))
                                    <li><a class="dropdown-item" href="{{ route('inside_files.index') }}"><i class="fab fa-linkedin-in" aria-hidden="true"></i> 內部文件</a></li>
                                @endif
                                @if(isset($module_setup['會議文稿']))
                                    <li><a class="dropdown-item" href="{{ route('meetings.index') }}"><i class="fas fa-comments" aria-hidden="true"></i> 會議文稿</a></li>
                                @endif
                                @if(isset($module_setup['報修系統']))
                                    <li><a class="dropdown-item" href="{{ route('fixes.index') }}"><i class="fas fa-wrench" aria-hidden="true"></i> 報修系統</a></li>
                                @endif
                                @if(isset($module_setup['教室預約']))
                                    <li><a class="dropdown-item" href="{{ route('classroom_orders.index') }}"><i class="fas fa-chess-rook" aria-hidden="true"></i> 教室預約</a></li>
                                @endif
                                @if(isset($module_setup['午餐系統']))
                                    <li><a class="dropdown-item" href="{{ route('lunches.index') }}"><i class="fas fa-utensils" aria-hidden="true"></i> 午餐系統</a></li>
                                @endif
                                @if(isset($module_setup['社團報名']))
                                    <li><a class="dropdown-item" href="{{ route('clubs.index') }}"><i class="fas fa-table-tennis" aria-hidden="true"></i> 社團報名</a></li>
                                @endif
                                @if(isset($module_setup['校園部落格']))
                                    <li><a class="dropdown-item" href="{{ route('blogs.index') }}"><i class="fas fa-newspaper" aria-hidden="true"></i> 校園部落格</a></li>
                                @endif
                                @if(isset($module_setup['行政待辦']))
                                    <li><a class="dropdown-item" href="{{ route('tasks.index') }}"><i class="fas fa-tasks" aria-hidden="true"></i> 行政待辦</a></li>
                                @endif
                                @if(isset($module_setup['借用系統']))
                                    <li><a class="dropdown-item" href="{{ route('lends.index') }}"><i class="fas fa-archive" aria-hidden="true"></i> 借用系統</a></li>
                                @endif
                                @if(isset($module_setup['校園跑馬燈']))
                                    <li><a class="dropdown-item" href="{{ route('school_marquee.index') }}"><i class="fas fa-running" aria-hidden="true"></i> 校園跑馬燈</a></li>
                                @endif
                                @if(isset($module_setup['運動會報名']))
                                    <li><a class="dropdown-item" href="{{ route('sport_meeting.index') }}"><i class="fas fa-volleyball-ball" aria-hidden="true"></i> 運動會報名</a></li>
                                @endif   
                                @if(isset($module_setup['填報學生']))
                                    <li><a class="dropdown-item" href="{{ route('report_students.index') }}"><i class="fas fa-child" aria-hidden="true"></i> 填報學生</a></li>
                                @endif                             
                                @if(isset($module_setup['學生帳號']))
                                    <li><a class="dropdown-item" href="{{ route('student_account.index') }}"><i class="far fa-user-circle" aria-hidden="true"></i> 學生帳號</a></li>
                                @endif                             
                                <li><a class="dropdown-item" href="{{ route('photo_links.index') }}"><i class="fas fa-image" aria-hidden="true"></i> 圖片連結</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->admin)
                        <li class="nav-item dropdown @yield('nav_setup_active')">
                            <?php $setup_name = ($setup->setup_name)?$setup->setup_name:"系統設定"; ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkAdminSetup" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                {{ $setup_name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLinkAdminSetup">
                                <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-user" aria-hidden="true"></i> 帳號管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('groups.index') }}"><i class="fas fa-users" aria-hidden="true"></i> 群組管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('departments.index') }}"><i class="fas fa-puzzle-piece" aria-hidden="true"></i> 學校介紹管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('school_marquee.setup') }}"><i class="fas fa-running" aria-hidden="true"></i> 校園跑馬燈管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('contents.index') }}"><i class="fas fa-file-alt" aria-hidden="true"></i> 內容管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('links.index') }}"><i class="fas fa-link" aria-hidden="true"></i> 選單連結</a></li>
                                <li><a class="dropdown-item" href="{{ route('photo_links.index') }}"><i class="fas fa-image" aria-hidden="true"></i> 圖片連結</a></li>
                                <li><a class="dropdown-item" href="{{ route('trees.index') }}"><i class="fas fa-tree" aria-hidden="true"></i> 樹狀目錄</a></li>
                                <li><a class="dropdown-item" href="{{ route('rss_feeds.index') }}"><i class="fas fa-rss" aria-hidden="true"></i> RSS 訊息</a></li>
                                <li><a class="dropdown-item" href="{{ route('setups.index') }}"><i class="fas fa-desktop" aria-hidden="true"></i> 網站設定</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dns.index') }}" target="_blank" title="DNS 網域設定 (另開新視窗)">
                                        <i class="fas fa-route" aria-hidden="true"></i> DNS 網域設定
                                        <span class="visually-hidden">(另開新視窗)</span>
                                    </a>
                                </li>                                
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item dropdown @yield('nav_user_active')">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLinkUser" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" title="使用者選單">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <span class="visually-hidden">使用者選單</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLinkUser">
                            <li>
                                <a class="dropdown-item" href="#" onclick="click_count()"><i class="fas fa-user" aria-hidden="true"></i> {{ auth()->user()->title }} {{ auth()->user()->name }}</a>
                                <script>
                                    var n=0;
                                    function click_count(){
                                        n = n+1;
                                        alert('點了'+n+'下!');
                                    }
                                </script>
                            </li>
                            @if(auth()->user()->login_type=="openID")
                                <li><a class="dropdown-item" href="{{ route('edit_title') }}"><i class="fas fa-user-tag" aria-hidden="true"></i> 更改職稱</a></li>
                            @endif
                            @if(auth()->user()->login_type=="local")
                                <li><a class="dropdown-item" href="{{ route('edit_password') }}"><i class="fas fa-key" aria-hidden="true"></i> 更改密碼</a></li>
                            @endif
                            @if(auth()->user()->admin)
                                <li><a class="dropdown-item" href="{{ route('teach_system') }}"><i class="fas fa-tag" aria-hidden="true"></i> 系統教學</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('wrench.index') }}"><i class="fas fa-wrench" aria-hidden="true"></i> 系統報錯與建議</a></li>
                            @impersonating
                                <li><a class="dropdown-item" href="{{ route('sims.impersonate_leave') }}" onclick="return confirm('確定返回原本帳號？')"><i class="fas fa-user-ninja" aria-hidden="true"></i> 結束模擬</a></li>
                            @endImpersonating
                            <li>
                                <a class="dropdown-item" href="#" onclick="if(sw_confirm2('您確定登出嗎?','logout_form')) document.getElementById('logout-form').submit(); else return false">
                                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i> 登出
                                </a>
                                <form id="logout_form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <?php $login_name = ($setup->login_name)?$setup->login_name:"登入"; ?>
                        <a class="nav-link" href="{{ route('logins') }}">{{ $login_name }}</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>