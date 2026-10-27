@extends('layouts.master')

@section('title', '本機帳號登入 | ')

@section('content')
<style>
    /* 無障礙 HM1020401C 修正：表單與按鈕 Focus 高對比視覺提示 */
    .form-control:focus-visible,
    .btn:focus-visible,
    a:focus-visible {
        outline: 3px solid #0056b3 !important;
        outline-offset: 2px !important;
        z-index: 5;
    }
</style>

<div class="row justify-content-center">
    <!-- 無障礙 HM1010301C：宣告主內容區域 -->
    <main class="col-md-6 col-lg-5" aria-label="本機帳號登入主要區域">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <!-- 統一標題級別與字體大小 (h5) -->
                <h1 class="h5 m-0 fw-bold">本機帳號登入</h1>
            </div>

            <div class="card-body p-4">
                @if(session('login_error') < 3)
                <form method="POST" action="{{ route('auth') }}" id="this_form">
                    @csrf

                    <!-- 本機帳號 -->
                    <div class="row mb-3 align-items-center">
                        <label for="username" class="col-md-4 col-form-label text-md-end fw-bold">本機帳號</label>
                        <div class="col-md-7">
                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">

                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 密碼 -->
                    <div class="row mb-3 align-items-center">
                        <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">密碼</label>
                        <div class="col-md-7">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- 驗證碼圖片與語音 (已修正為免刷新頁面) -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-4 text-md-end fw-bold">
                            圖形驗證碼
                        </div>
                        <div class="col-md-7 text-md-start">
                            <a href="#!" id="refreshPic" title="點擊重新產生背景色" aria-label="點擊重新產生背景色">
                                <img src="{{ route('pic') }}" id="captchaPic" class="img-fluid border rounded" alt="圖形驗證碼：請閱讀圖片內的國字並轉換為數字輸入">
                            </a>                       
                            <a href="#!" id="loadAudio" class="d-inline-block ms-2 text-primary text-decoration-none" role="button" aria-label="播放驗證碼語音">
                                <i class="fas fa-volume-up" aria-hidden="true"></i> [語音播放]
                            </a>
                            <audio id="myAudio">
                                <source src="" type="audio/mp3">                                
                            </audio>                            
                        </div>
                    </div>

                    <!-- 驗證碼輸入 -->
                    <div class="row mb-3 align-items-center">
                        <label for="chaptcha" class="col-md-4 col-form-label text-md-end fw-bold">驗證碼答案</label>
                        <div class="col-md-7">
                            <input type="text" id="chaptcha" class="form-control" name="chaptcha" required placeholder="上圖國字轉阿拉伯數字" maxlength="5" title="請輸入圖形驗證碼對應的數字">
                        </div>
                    </div>

                    <!-- 送出按鈕 -->
                    <div class="row mb-0">
                        <div class="col-md-7 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold">
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
                        <label for="check_bot" class="visually-hidden">防機器人驗證碼</label>
                        <input type="text" id="check_bot" name="check_bot" class="form-control" style="max-width: 180px;" placeholder="請輸入：{{ session('check_bot') }}" required>
                        <button type="submit" class="btn btn-primary btn-sm fw-bold">我不是機器人</button>
                    </form>
                @endif
                @if(session('login_error') < 3)
                    @include('layouts.errors')
                @endif

                <hr class="my-3">

                <!-- OpenID 登入整合 -->
                <div class="text-end">
                    <a href="{{ route('sso') }}" class="d-inline-flex flex-column align-items-center text-decoration-none" aria-label="使用 彰化縣 OpenID 登入">
                        <img src="{{ asset('images/chc.jpg') }}" alt="彰化縣 Education OpenID Logo" width="70" class="mb-1">
                        <span class="small fw-bold text-dark">彰化 OpenID 登入</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    $(document).ready(function () {
        if ($.fn.validate) {
            $("#this_form").validate();
        }

        // 點擊圖片無刷新更換驗證碼（保持輸入框內容）
        $('#refreshPic').click(function (e) {
            e.preventDefault();
            $('#captchaPic').attr('src', '{{ route('pic') }}?' + new Date().getTime());
        });

        // 語音播放 AJAX
        $('#loadAudio').click(function (e) {
            e.preventDefault();
            var $btn = $(this);
            $btn.addClass('disabled').html('<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> 載入中...');

            $.ajax({
                url: '{{ route('voice') }}',
                type: 'GET',
                success: function (response) {
                    if (response.startsWith('Error')) {
                        alert(response);
                    } else {
                        const base64Src = `data:audio/mpeg;base64,${response}`;
                        $('#myAudio source').attr('src', base64Src);
                        
                        var audio = $('#myAudio')[0];
                        audio.load();
                        audio.play();
                    }
                },
                error: function () {
                    alert('無法載入音頻數據，請稍後再試！');
                },
                complete: function () {
                    $btn.removeClass('disabled').html('<i class="fas fa-volume-up" aria-hidden="true"></i> [語音播放]');
                }
            });
        });
    });
</script>
@endsection