@extends('layouts.master')

@section('nav_setup_active', 'active')

@section('title', '帳號管理 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3">
                帳號管理
            </h1>
            <?php
            $active[1] = "active";
            $active[2] = "";
            ?>
            @include('users.nav',$active)
            @include('users.form')
        </div>
    </div>
@endsection