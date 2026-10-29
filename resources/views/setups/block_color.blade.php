@extends('layouts.master_clean')

@section('title', '區塊顏色樣式 | ')

@section('content')
<link href="{{ asset('css/block_style.css') }}" rel="stylesheet">

<div class="container-fluid py-3">
    <!-- 頂部標題與返回按鈕區塊 -->
    <div class="card shadow-sm border mb-4">
        <div class="card-header bg-light text-dark fw-bold py-3 d-flex justify-content-between align-items-center">
            <span style="font-size: 1.1rem;">
                <i class="fas fa-palette me-2 text-primary"></i> 區塊標題底色與樣式參考表
            </span>
            <a href="#" onclick="history.back()" class="btn btn-outline-secondary btn-sm px-3">
                <i class="fas fa-arrow-left me-1"></i> 返回上一頁
            </a>
        </div>
    </div>

    <!-- 1. 單色系標題區塊 -->
    <div class="card shadow-sm border mb-4">
        <div class="card-header bg-white fw-bold border-bottom py-2">
            <i class="fas fa-square me-1 text-success"></i> 標準單色系 (Solid Colors)
        </div>
        <div class="card-body bg-light p-3">
            <div class="row justify-content-center">
                <div class="col-md-3 block1 shadow rounded" style="margin: 10px;">
                    <div class="title1">
                        <h4>單色綠</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 block2 shadow rounded" style="margin: 10px;">
                    <div class="title2">
                        <h4>單色黃</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 block3 shadow rounded" style="margin: 10px;">
                    <div class="title3">
                        <h4>單色藍</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 block4 shadow rounded" style="margin: 10px;">
                    <div class="title4">
                        <h4>單色紅</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. 柔和淺色系標題區塊 -->
    <div class="card shadow-sm border mb-4">
        <div class="card-header bg-white fw-bold border-bottom py-2">
            <i class="fas fa-adjust me-1 text-info"></i> 柔和粉淺色系 (Soft Colors)
        </div>
        <div class="card-body bg-light p-3">
            <div class="row justify-content-center">
                <div class="col-md-3 soft-block1 shadow rounded" style="margin: 10px;">
                    <div class="soft-title1">
                        <h4>單色淺綠</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 soft-block2 shadow rounded" style="margin: 10px;">
                    <div class="soft-title2">
                        <h4>單色淺黃</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 soft-block3 shadow rounded" style="margin: 10px;">
                    <div class="soft-title3">
                        <h4>單色淺藍</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 soft-block4 shadow rounded" style="margin: 10px;">
                    <div class="soft-title4">
                        <h4>單色淺紅</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-3 soft-block5 shadow rounded" style="margin: 10px;">
                    <div class="soft-title5">
                        <h4>單色淺淺藍</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 soft-block6 shadow rounded" style="margin: 10px;">
                    <div class="soft-title6">
                        <h4>單色淺膚色</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 soft-block7 shadow rounded" style="margin: 10px;">
                    <div class="soft-title7">
                        <h4>單色淺淺黃</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 soft-block8 shadow rounded" style="margin: 10px;">
                    <div class="soft-title8">
                        <h4>單色淺淺紅</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. 漸層與底線風格區塊 -->
    <div class="card shadow-sm border mb-4">
        <div class="card-header bg-white fw-bold border-bottom py-2">
            <i class="fas fa-paint-brush me-1 text-warning"></i> 漸層色與底線風格 (Gradients & Underlines)
        </div>
        <div class="card-body bg-light p-3">
            <div class="row justify-content-center">
                <div class="col-md-3 gradient-block1 shadow rounded" style="margin: 10px;">
                    <div class="gradient-title1">
                        <h4>漸層紅</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 gradient-block2 shadow rounded" style="margin: 10px;">
                    <div class="gradient-title2">
                        <h4>漸層藍</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 gradient-block3 shadow rounded" style="margin: 10px;">
                    <div class="gradient-title3">
                        <h4>漸層綠</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 gradient-block4 shadow rounded" style="margin: 10px;">
                    <div class="gradient-title4">
                        <h4>漸層黃</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>

                <div class="col-md-3 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title1">
                        <h4>黃底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title2">
                        <h4>綠底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title3">
                        <h4>藍底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title4">
                        <h4>紅底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>

                <div class="col-md-3 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title5">
                        <h4>紫底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-3 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title6">
                        <h4>橘底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title7">
                        <h4>青底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
                <div class="col-md-2 sp-block1 shadow rounded" style="margin: 10px;">
                    <div class="sp-title8">
                        <h4>灰底線</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. 預設灰色系區塊 -->
    <div class="card shadow-sm border mb-4">
        <div class="card-header bg-white fw-bold border-bottom py-2">
            <i class="fas fa-th me-1 text-secondary"></i> 預設灰色系 (Default Greys)
        </div>
        <div class="card-body bg-light p-3">
            <div class="row justify-content-center">
                <div class="col-md-8 default-block1 shadow rounded" style="margin: 10px;">
                    <div class="default-title1">
                        <h4>預設深灰</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 default-block2 shadow rounded" style="margin: 10px;">
                    <div class="default-title2">
                        <h4>預設淺灰</h4>
                    </div>
                    <div class="content2">
                        <p>彰化縣網中心首頁代管，歡迎使用！</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection