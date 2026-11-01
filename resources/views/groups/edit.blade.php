@extends('layouts.master_clean')

@section('nav_setup_active', 'active')

@section('title', '編輯群組 | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3"><i class="fas fa-users me-2" aria-hidden="true"></i>編輯群組</h1>            
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <form action="{{ route('groups.update', $group->id) }}" method="POST" id="this_form1">
                        @csrf
                        @method('PATCH')
                        @include('groups.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection