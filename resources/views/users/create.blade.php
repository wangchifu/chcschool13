@extends('layouts.master_clean')

@section('title', '新增本機帳號 | ')

@section('content')
    <div class="container py-3">
        <h1 class="h4 mb-3">新增本機帳號</h1>

        <form action="{{ route('users.store') }}" method="POST" aria-label="新增本機帳號表單" id="this_form1">
            @csrf
            <div class="table-responsive mb-3">
                <table class="table table-striped table-hover align-middle mb-0" aria-label="新增帳號列表">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">帳號</th>
                        <th scope="col">密碼</th>
                        <th scope="col">職稱</th>
                        <th scope="col">姓名</th>
                        <th scope="col" style="width: 100px;">排序</th>
                        <th scope="col">群組</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="username" id="username" class="form-control" required placeholder="帳號" aria-label="帳號">
                        </td>
                        <td>
                            <span class="text-secondary fw-bold">demo1234</span>
                        </td>
                        <td>
                            <input type="text" name="title" id="title" class="form-control" required placeholder="職稱" aria-label="職稱">
                        </td>
                        <td>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="姓名" aria-label="姓名">
                        </td>
                        <td>
                            <input type="text" name="order_by" id="order_by" class="form-control" maxlength="3" aria-label="排序">
                        </td>
                        <td>
                            <select name="group_id[]" id="group_id" class="form-select" multiple aria-label="選擇群組">
                                <option value="">---可多選群組---</option>
                                @foreach($groups as $g_id => $g_name)
                                    <option value="{{ $g_id }}">{{ $g_name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            @include('layouts.errors')
            <button type="button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定嗎？','this_form1')">
                <i class="fas fa-save me-1" aria-hidden="true"></i> 儲存變更
            </button>
        </form>
    </div>
@endsection