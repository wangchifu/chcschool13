@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '群組管理 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3"><i class="fas fa-users me-2" aria-hidden="true"></i>群組管理</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">首頁</a></li>
                    <li class="breadcrumb-item active" aria-current="page">群組管理</li>
                </ol>
            </nav>
            <a href="{{ route('groups.create') }}" class="btn btn-success btn-sm mb-2 venobox" data-vbtype="iframe">
                <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增群組
            </a>
            <div class="card my-4 shadow-sm">
                <h2 class="card-header h5">群組列表</h2>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0" aria-label="群組列表表格">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 80px;">序號</th>
                                <th scope="col">名稱</th>
                                <th scope="col">所屬人員</th>
                                <th scope="col">停用?</th>
                                <th scope="col" style="width: 180px;">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($groups as $group)
                                <tr>
                                    <td>
                                        {{ $i }}
                                    </td>
                                    <td>
                                        {{ $group->name }}
                                    </td>
                                    <td>
                                        @if(!empty($user_group_data[$group->id]))
                                            {{ count($user_group_data[$group->id]) }}
                                        @else
                                            0
                                        @endif
                                        <a href="{{ route('users_groups', $group->id) }}" class="btn btn-info btn-sm ms-1 text-white venobox" data-vbtype="iframe">
                                            <i class="fas fa-list me-1" aria-hidden="true"></i> 人員
                                        </a>
                                    </td>
                                    <td>
                                        @if($group->disable)
                                            <span class="badge bg-danger">已停用</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($group->id > 4)
                                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-outline-primary btn-sm me-1 venobox" data-vbtype="iframe">
                                                <i class="fas fa-edit me-1" aria-hidden="true"></i> 修改
                                            </a>
                                            <a href="#!" class="btn btn-danger btn-sm" onclick="sw_confirm2('您確定送出嗎?','delete{{ $group->id }}')">
                                                <i class="fas fa-trash me-1" aria-hidden="true"></i> 刪除
                                            </a>
                                        @else
                                            <span class="text-muted">內定群組</span>
                                        @endif
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                <form action="{{ route('groups.destroy', $group->id) }}" method="POST" id="delete{{ $group->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection