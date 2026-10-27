@extends('layouts.master_close')

@section('title','管理登入 | ')

@section('content')
<div class="row justify-content-center">
    <main class="col-md-6 col-lg-5" aria-label="管理員登入主要區域">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <!-- 統一標題級別與字體大小 (h5) -->
                <h1 class="h5 m-0 fw-bold">管理員登入</h1>
            </div>

            <div class="card-body p-4">
                @if(session('login_error') < 3)
                <form method="POST" action="{{ route('auth_close') }}" id="this_form">
                    @csrf

                    <div class="row mb-3 align-items-center">
                        <label for="username" class="col-md-4 col-form-label text-md-end fw-bold">帳號</label>

                        <div class="col-md-7">
                            <input tabindex="1" id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">密碼</label>

                        <div class="col-md-7">
                            <input id="password" type="password" tabindex="2" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 驗證碼圖片 (已修正為免刷新頁面) -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end fw-bold">
                            圖形驗證碼
                        </div>
                        <div class="col-md-7 text-md-start">
                            <a href="#!" id="refreshPic" title="點擊重新產生驗證碼" aria-label="點擊重新產生驗證碼">
                                <img src="{{ route('pic') }}" id="captchaPic" class="img-fluid border rounded" alt="驗證碼圖片">
                            </a>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label for="chaptcha" class="col-md-4 col-form-label text-md-end fw-bold">驗證碼</label>

                        <div class="col-md-7">
                            <input type="text" tabindex="3" class="form-control" id="chaptcha" name="chaptcha" required placeholder="上圖國字轉阿拉伯數字" maxlength="5">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-7 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold" tabindex="4">
                                <i class="fas fa-sign-in-alt" aria-hidden="true"></i> 登入
                            </button>
                        </div>
                    </div>
                </form>
                @else
                    <?php
                        $k = rand(100,999);
                        session(['check_bot'=>$k]);
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>登入錯誤超過三次！</strong> 請輸入下方防機器人三碼數字後送出：
                    </div>
                    <form action="{{ route('not_bot') }}" method="post" class="d-flex align-items-center justify-content-center gap-2 my-3">
                        @csrf
                        <input type="text" name="check_bot" class="form-control" style="max-width: 180px;" placeholder="請輸入：{{ session('check_bot') }}" required>
                        <button type="submit" class="btn btn-primary btn-sm fw-bold">我不是機器人</button>
                    </form>
                @endif
                @if(session('login_error') < 3)
                    @include('layouts.errors')
                @endif
            </div>
        </div>
    </main>
</div>
<script>
    $(document).ready(function() {
        if ($.fn.validate) {
            $("#this_form").validate();
        }

        // 點擊圖片無刷新更換驗證碼（保持已輸入內容）
        $('#refreshPic').click(function (e) {
            e.preventDefault();
            $('#captchaPic').attr('src', '{{ route('pic') }}?' + new Date().getTime());
        });
    });
</script>
@endsection