@extends('layouts.auth')

@section('content')
<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">{{ __('Reset Password') }}</h1>
            </div>
            <form class="form-horizontal form-material user" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                 <div class="form-group">
                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" readonly autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>
                <div class="form-group">
                     <input type="password" placeholder="{{__('Enter new password...')}}" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" placeholder="{{__('Enter confirm password...')}}" class="form-control form-control-user" name="password_confirmation" autocomplete="new-password">
                </div>

                <button class="btn btn-primary btn-user btn-block" type="submit">
                    {{__('Reset Password')}}
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{route('login')}}">{{__('Login!')}}</a>
            </div>
        </div>
    </div>
</div>
@endsection
