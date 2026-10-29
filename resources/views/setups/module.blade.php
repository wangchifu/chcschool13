@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '模組功能 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1>網站設定</h1>

            <?php
            $active[1] = "";
            $active[2] = "";
            $active[3] = "";
            $active[4] = "";
            $active[5] = "active";
            $active[6] = "";
            $active[7] = "";
            $module_setup = get_module_setup();
            ?>
            @include('setups.nav', $active)

            <!-- 頂部標題與操作區 -->
            <div class="d-flex justify-content-between align-items-center my-3">
                <h3 class="m-0">模組功能與權限配置</h3>
            </div>

            <form action="{{ route('setups.update_module') }}" method="post" id="this_form1">
                @csrf
                <div class="card my-3 shadow-sm border">
                    <!-- 頁首已改為 bg-light text-dark -->
                    <div class="card-header bg-light text-dark fw-bold d-flex justify-content-between align-items-center py-3">
                        <span style="font-size: 1.1rem;"><i class="fas fa-cubes me-2 text-primary"></i> 系統模組開關與管理權限分配</span>                        
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 18%;" class="ps-4">模組名稱</th>
                                        <th style="width: 20%;" class="text-center">狀態 (啟用 / 停用)</th>
                                        <th style="width: 62%;">管理權限說明與人選指定</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modules as $k => $v)
                                        <?php
                                        $check1 = (isset($module_setup[$v])) ? "checked" : "";
                                        $check2 = (isset($module_setup[$v])) ? "" : "checked";
                                        ?>
                                        <tr>
                                            <td class="align-middle ps-4 fw-bold text-dark">
                                                <i class="fas fa-cube text-secondary me-2"></i>{{ $v }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="form-check form-check-inline mb-1">
                                                    <input type="radio" name="module[{{ $v }}]" value="1" id="{{ $k }}1" class="form-check-input" {{ $check1 }}>
                                                    <label class="form-check-label text-success fw-bold" for="{{ $k }}1">啟用</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" name="module[{{ $v }}]" value="" id="{{ $k }}2" class="form-check-input" {{ $check2 }}>
                                                    <label class="form-check-label text-secondary" for="{{ $k }}2">停用</label>
                                                </div>
                                            </td>
                                            <td class="align-middle py-3">
                                                @if($v=="公告系統")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可發公告，管理員可置頂</span>
                                                @elseif($v=="檔案庫")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可掛檔案</span>
                                                @elseif($v=="好站連結")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>管理員可綁連結</span>
                                                @elseif($v=="內部文件")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可增加檔案</span>
                                                @elseif($v=="會議文稿")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可報告事項</span>
                                                @elseif($v=="校務行政")
                                                    <span class="text-muted">--</span>
                                                @elseif($v=="處室介紹")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>管理員編修</span>
                                                @elseif($v=="報修系統")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「可回覆」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')" title="刪除權限">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="校務行事曆")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>管理員設置年度後，行政人員可編行事</span>
                                                @elseif($v=="校務月曆")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可編行事</span>
                                                @elseif($v=="午餐系統")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「午餐業務」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')" title="刪除權限">
                                                                    <i class="fas fa-times-circle"></i>
                                                                </a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="教師差假")
                                                    <div class="d-flex flex-column gap-1">
                                                        <div class="mb-1">
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「校長」權限
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div class="mb-1">
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'B']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「人事主任」權限
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','B')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div class="mb-1">
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'D']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「單位主管」權限
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','D')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'E']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「教學組長」權限
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','E')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @elseif($v=="社團報名")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「社團業務」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="校園部落格")
                                                    <span class="text-muted"><i class="fas fa-info-circle me-1"></i>行政人員可編輯新文章，管理員可刪除任一文章</span>
                                                @elseif($v=="教室預約")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「可編輯教室」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="借用系統")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「可管理借用」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="運動會報名")
                                                    <div class="d-flex flex-column gap-1">
                                                        <div class="mb-1">
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「系統管理」
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'B']) }}" class="btn btn-outline-info btn-sm me-2 py-0 venobox" data-vbtype="iframe">
                                                                <i class="fas fa-user-plus me-1"></i> 新指定「成績輸入」
                                                            </a>
                                                            <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','B')->get(); ?>
                                                            @foreach($user_powers as $user_power)
                                                                <span class="badge bg-success p-1 px-2 me-1 fw-normal">
                                                                    {{ $user_power->user->name }}
                                                                    <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @elseif($v=="填報學生")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「系統管理」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @elseif($v=="學生帳號")
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <a href="{{ route('user_powers.create',['module'=>$v,'type'=>'A']) }}" class="btn btn-outline-info btn-sm me-2 mb-1 venobox" data-vbtype="iframe">
                                                            <i class="fas fa-user-plus me-1"></i> 新指定「系統管理」
                                                        </a>
                                                        <?php $user_powers = \App\Models\UserPower::where('name',$v)->where('type','A')->get(); ?>
                                                        @foreach($user_powers as $user_power)
                                                            <span class="badge bg-success p-2 me-1 mb-1 fw-normal">
                                                                已指定：{{ $user_power->user->name }}
                                                                <a href="#!" class="text-white ms-1" onclick="sw_confirm1('確定刪除？','{{ route('user_powers.destroy',$user_power->id) }}')"><i class="fas fa-times-circle"></i></a>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end py-3">
                        <button type="button" id="this_form1_button" class="btn btn-primary px-4" onclick="sw_confirm2('確定儲存模組設定？','this_form1','this_form1_button')">
                            <i class="fas fa-save me-1"></i> 儲存模組變更
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
@endsection