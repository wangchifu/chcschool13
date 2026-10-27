@extends('layouts.master')

@section('title','系統管理員登入 | ')

@section('content')
<div class="row justify-content-center">
    <main class="col-md-6 col-lg-5" aria-label="系統管理員登入主要區域">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-3">
                <!-- 統一標題級別與字體大小 (h5) -->
                <h1 class="h5 m-0 fw-bold">系統管理員登入</h1>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">                        
                        @if(session('login_error') < 3)
                        <form id="this_form" method="POST" action="{{ route('sys_auth') }}" onsubmit="change_button()">
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="username" class="col-md-4 col-form-label text-md-end fw-bold">帳號</label>
                                <div class="col-md-7">
                                    <input tabindex="1" id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="請輸入帳號" autocomplete="username">
                                </div>
                            </div>
        
                            <div class="row mb-3 align-items-center">
                                <label for="password" class="col-md-4 col-form-label text-md-end fw-bold">密碼</label>
                                <div class="col-md-7">
                                    <input tabindex="2" id="password" type="password" class="form-control" name="password" required placeholder="請輸入密碼" autocomplete="current-password">
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
                                    <a href="#!" id="loadAudio" class="ms-2 text-decoration-none" role="button" aria-label="播放驗證碼語音"><i class="fas fa-volume-up" aria-hidden="true"></i> [語音播放]</a>
                                    <audio id="myAudio">
                                        <source src="" type="audio/mp3">                                
                                    </audio>   
                                </div>
                            </div>

                            <div class="row mb-3 align-items-center">
                                <label for="chaptcha" class="col-md-4 col-form-label text-md-end fw-bold">驗證碼答案</label>                        
                                <div class="col-md-7">
                                    <input tabindex="3" id="chaptcha" type="text" class="form-control" name="chaptcha" required placeholder="上圖國字轉阿拉伯數字" maxlength="5" title="請輸入驗證碼">                            
                                </div>
                            </div>
        
                            <div class="row mb-0">
                                <div class="col-md-7 offset-md-4">
                                    <button tabindex="4" type="submit" class="btn btn-primary btn-sm px-3 fw-bold" id="submit_button">
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
                        @include('layouts.errors')
                    </div>                                   
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    function change_button(){
        $("#submit_button").attr('disabled','disabled').addClass('disabled');
    }

    $(document).ready(function () {
        // 點擊圖片無刷新更換驗證碼（保持已輸入內容）
        $('#refreshPic').click(function (e) {
            e.preventDefault();
            $('#captchaPic').attr('src', '{{ route('pic') }}?' + new Date().getTime());
        });

        // 語音播放 AJAX
        $('#loadAudio').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('voice') }}',
                type: 'GET',
                success: function (response) {
                    if (response.startsWith('Error')) {
                        alert(response);
                    } else {
                        const base64Src = `data:audio/mpeg;base64,${response}`;
                        $('#myAudio source').attr('src', base64Src);
                        $('#myAudio')[0].load();
                        $('#myAudio')[0].play();
                    }
                },
                error: function () {
                    alert('無法載入音頻數據！');
                }
            });
        });
    });
</script>
@endsection