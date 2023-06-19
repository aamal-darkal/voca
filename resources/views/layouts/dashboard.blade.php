@extends('layouts.app')
@section('left-nav')
    <a class="down-arrow d-lg-none fs-5 text-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive"
        aria-controls="offcanvasResponsive">
        <i class="fas fa-circle-chevron-down"></i>
    </a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-xl-2">
                @include('layouts.aside')
            </div>
            <div class="col-lg-9 col-xl-10">
                @yield('inside-content')
            </div>
        </div>
    </div>
@endsection
