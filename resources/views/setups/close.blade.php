@extends('layouts.master_close')

@section('content')
<div class="row justify-content-center align-items-center my-5">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow border-0 text-center p-4">
            <div class="card-body">
                <h1 class="display-6 fw-bold text-dark mb-4">{{ $setup->close_website }}</h1>
                <div class="my-4">
                    <img src="{{ asset('images/closed.png') }}" class="img-fluid rounded" alt="網站維護關閉中">
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end pe-3 pb-3">
                <a href="{{ route('login_close') }}" class="text-secondary fs-5" title="管理員登入">
                    <i class="fas fa-cog"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection