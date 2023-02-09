@extends('layouts.auth')

@section('content')

<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">{{__('Forgot Your Password?')}}</h1>
                <p class="mb-4">We get it, stuff happens. Just enter your email address below
                    and we'll send you a link to reset your password!</p>
            </div>
            <form class="form-horizontal form-material user" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" aria-describedby="emailHelp"
                        placeholder="Enter Email Address...">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-user btn-block  form-control form-control-user text-black">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{route('login')}}">{{__('Login!')}}</a>
            </div>
        </div>
    </div>
</div>

@endsection