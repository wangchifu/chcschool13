@extends('layouts.master_clean')

@section('nav_setup_active', 'active')

@section('title', '使用者-群組列表 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3"><i class="fas fa-users me-2" aria-hidden="true"></i>使用者-[ {{ $group->name }} ]列表管理</h1>            
            <div class="row justify-content-center">
                <div class="col-md-9 mb-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0" aria-label="群組使用者列表">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 70px;">序號</th>
                                <th scope="col">帳號</th>
                                <th scope="col">姓名</th>
                                <th scope="col">職稱</th>
                                <th scope="col">在職狀況</th>
                                <th scope="col" style="width: 130px;">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($user_data as $k => $v)
                                <tr>
                                    <td>
                                        {{ $i }}
                                    </td>
                                    <td>
                                        {{ $v['username'] }}
                                    </td>
                                    <td>
                                        {{ $v['name'] }}
                                    </td>
                                    <td>
                                        {{ $v['title'] }}
                                    </td>
                                    <td>
                                        @if($v['disable'])
                                            <span class="badge bg-danger">已離職</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="sw_confirm2('確定離開嗎?','delete{{ $v['id'] }}')">
                                            <i class="fas fa-walking me-1" aria-hidden="true"></i> 離開群組
                                        </button>
                                    </td>
                                    <form action="{{ route('users_groups.destroy') }}" method="POST" id="delete{{ $v['id'] }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                        <input type="hidden" name="user_id" value="{{ $v['id'] }}">
                                    </form>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-3">
                    <form action="{{ route('users_groups.store') }}" method="POST" id="this_form1">
                        @csrf
                        <select name="user_id[]" id="user_id" class="form-select mb-3" multiple size="20" aria-label="選擇加入的使用者">
                            <option value="" disabled>---可多選---</option>
                            @foreach($user_menu as $u_id => $u_name)
                                <option value="{{ $u_id }}">{{ $u_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success btn-sm w-100" onclick="sw_confirm2('確定加入？','this_form1')">
                            <i class="fas fa-plus me-1" aria-hidden="true"></i> 加入使用者
                        </button>
                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection