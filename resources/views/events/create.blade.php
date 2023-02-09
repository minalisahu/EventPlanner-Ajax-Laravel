@extends('layouts.app')

@section('content')

<div class="page-breadcrumb bg-white">
    <div class="row align-items-center">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Events</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <div class="d-md-flex">
                <ol class="breadcrumb ms-auto">
                    <li><a href="{{route('home')}}" class="fw-normal">Dashboard</a></li>
                </ol>
                <a href="{{route('event.list')}}" class="btn btn-sm btn-dark  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">List</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <div class="card shadow mb-4">
                <form class="form-horizontal form-material" method="POST" class="prevent-multi-submissions" action="{{route('event.store')}}"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include ('events.form', ['event' => null])
                    </div>
                    <div class="card-footer text-right p-2">
                        <button class="btn btn-primary button-prevent-multi-submissions">{{__('Create')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection