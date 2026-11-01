@extends('layouts.master_clean')

@section('title', '編輯帳號 | ')

@section('content')
    <div class="container py-3">
        <form action="{{ route('users.update', $user->id) }}" method="POST" aria-label="編輯帳號表單" id="this_form1">
            @csrf
            @method('PATCH')
            <div class="table-responsive mb-3">
                <table class="table table-striped table-hover align-middle mb-0" aria-label="編輯帳號表格">
                    <thead class="table-light">
                    <tr>
                        <th scope="col" colspan="5">
                            姓名：{{ $user->name }} 帳號：{{ $user->username }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="text-nowrap me-2">目前為：{{ $user->title }}，改為：</span>
                                <select class="form-select" id="title" name="title" tabindex="1" required aria-label="選擇職稱">
                                    @foreach($title_array as $k => $v)
                                        <option value="{{ $v }}" {{ ($user->title == $v) ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach                            
                                </select>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required readonly placeholder="姓名" aria-label="姓名">
                        </td>
                        <td style="width: 110px;">
                            <label for="order_by" class="form-label mb-1 small fw-bold">排序：</label>
                            <input type="text" name="order_by" id="order_by" value="{{ $user->order_by }}" class="form-control" maxlength="3" aria-label="排序">
                        </td>
                        <td style="width: 220px;">
                            <label for="group_id" class="form-label mb-1 small fw-bold">群組：</label>
                            <select name="group_id[]" id="group_id" class="form-select" multiple aria-label="選擇群組">
                                <option value="">---可多選群組---</option>
                                @foreach($groups as $g_id => $g_name)
                                    <option value="{{ $g_id }}" {{ (is_array($default_group) ? in_array($g_id, $default_group) : $default_group == $g_id) ? 'selected' : '' }}>
                                        {{ $g_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <?php
                                $check1 = ($user->disable)?"":"checked";
                                $check2 = ($user->disable)?"checked":"";
                                $admin = ($user->admin)?"checked":"";
                                $disabled = ($user->username=="admin")?"disabled":null;
                            ?>
                            @if(auth()->user()->id != $user->id)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="disable" value="" id="enable" {{ $check1 }}>
                                    <label class="form-check-label" for="enable">在職</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="disable" value="1" id="disable" {{ $check2 }}>
                                    <label class="form-check-label text-danger fw-bold" for="disable">離職</label>
                                </div>
                            @endif
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="admin" value="1" id="admin" {{ $admin }} {{ $disabled }}>
                                    <label class="form-check-label" for="admin">網站管理者</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定嗎？','this_form1')">
                <i class="fas fa-save me-1" aria-hidden="true"></i> 儲存變更
            </button>
        </form>
        @include('layouts.errors')
    </div>
@endsection