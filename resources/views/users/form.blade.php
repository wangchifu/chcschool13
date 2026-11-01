<div class="card my-4">
    <h2 class="card-header h5">列表</h2>
    <div class="card-body">
        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm mb-2 venobox" data-vbtype="iframe">
            <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增本機帳號
        </a>
        <div class="text-danger mb-3 fw-bold">以下如果有相同姓名的帳號，請離職 gsuite 的舊帳號</div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0" style="word-break:break-all;" aria-label="教職員帳號列表">
                <thead class="table-light">
                <tr>
                    <th scope="col" class="text-nowrap">排序</th>
                    <th scope="col">姓名(帳號)</th>
                    <th scope="col">職稱</th>
                    <th scope="col">群組</th>
                    <th scope="col">類別</th>
                    <th scope="col">最後登入</th>
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
                        <td>
                            {{ $user->updated_at }}
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('users.edit',$user->id) }}" class="btn btn-outline-primary btn-sm me-1 venobox" data-vbtype="iframe">
                                <i class="fas fa-edit me-1" aria-hidden="true"></i> 修改
                            </a>
                            @if($user->login_type=="local")
                                <a href="#!" class="btn btn-warning btn-sm me-1" onclick="sw_confirm1('確定？','{{ route('users.back_pwd',$user->id) }}')">還原密碼</a>
                            @endif
                            @if($user->id != auth()->user()->id)
                                <a href="#!" class="btn btn-secondary btn-sm" onclick="sw_confirm1('確定模擬？','{{ route('sims.impersonate',$user->id) }}')">
                                    <i class="fas fa-user-ninja me-1" aria-hidden="true"></i> 模擬登入
                                </a>
                            @endif
                        </td>                    
                    </tr>
                @endforeach
                </tbody>
            </table>        
        </div>
    </div>
</div>