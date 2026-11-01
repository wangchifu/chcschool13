@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '帳號管理 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3">
                系統管理員已登入
            </h1>            
            <a href="{{ route('sys_logout') }}" class="btn btn-danger btn-sm mb-3" onclick="return confirm('確定登出？')">
                <i class="fas fa-sign-out-alt me-1" aria-hidden="true"></i> 登出系統管理員
            </a>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0" style="word-break:break-all;" aria-label="系統管理員查看帳號列表">
                    <caption class="visually-hidden">系統管理員查看帳號表格列表</caption>
                    <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">排序</th>
                        <th scope="col">姓名(帳號)</th>
                        <th scope="col">職稱</th>
                        <th scope="col">群組</th>
                        <th scope="col">類別</th>
                        <th scope="col" class="text-nowrap">動作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-nowrap">
                                @if($user->disable)
                                    <i class="fas fa-times-circle text-danger me-1" aria-hidden="true"></i>
                                @else
                                    <i class="fas fa-check-circle text-success me-1" aria-hidden="true"></i>
                                @endif
                                {{ $user->order_by }}
                            </td>
                            <td>
                                @if($user->admin)
                                    <i class="fas fa-crown text-warning me-1" aria-hidden="true"></i>
                                @endif
                                {{ $user->name }} ({{ $user->username }})
                            </td>
                            <td>
                                {{ $user->title }}
                            </td>
                            <td>
                                @foreach($user->groups as $group)
                                    <span class="badge bg-secondary me-1">{{ $group->group->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->login_type=="local")
                                    本機帳號
                                @elseif($user->login_type=="gsuite")
                                    gsuite帳號
                                @elseif($user->login_type=="openID")
                                    openID帳號
                                @endif
                            </td>
                            <td class="text-nowrap">                                                        
                                <a href="#!" class="btn btn-secondary btn-sm" onclick="sw_confirm1('確定模擬？','{{ route('sys_sim',$user->id) }}')">
                                    <i class="fas fa-user-ninja me-1" aria-hidden="true"></i> 模擬登入
                                </a>                            
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>             
        </div>
    </div>
@endsection