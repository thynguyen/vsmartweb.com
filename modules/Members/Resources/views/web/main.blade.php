@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Members','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_members_main')}}
@endsection
@section('header')
@endsection
@section('content')
<div id="logreg-forms">
    {!!Form::open(['method' => 'POST', 'route' => 'members.web.main', 'enctype'=> 'multipart/form-data'])!!}
    @include('layouts.flash-message')
    <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> {{ trans('Langcore::global.Login') }}</h1>
    <div class="social-login">
        <button class="btn facebook-btn social-btn" type="button" onclick="window.location.href='{{ route('members.web.authredirect',['provider'=>'facebook']) }}'">
            <span><i class="fab fa-facebook-f"></i></span>
        </button>
        <button class="btn google-btn social-btn" type="button" onclick="window.location.href='{{ route('members.web.authredirect',['provider'=>'google']) }}'">
            <span><i class="fab fa-google-plus-g"></i></span>
        </button>
    </div>
    <p style="text-align:center">
        OR
    </p>
    {!! Form::text('username', old('username'), ['class' => $errors->has('username') ? 'form-control is-invalid' : 'form-control','id'=>'username','placeholder'=>trans('Langcore::global.Login_username')]) !!}
    @if ($errors->has('username'))
    <div class="invalid-feedback">
        {{ $errors->first('username') }}
    </div>
    @endif
    {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password','placeholder'=>trans('Langcore::global.Password')]) !!}
    @if ($errors->has('password'))
    <div class="invalid-feedback">
        {{ $errors->first('password') }}
    </div>
    @endif
    <div class="form-group form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
    </div>

    <button class="btn btn-success btn-block" type="submit">
        <i class="fas fa-sign-in-alt"></i> {{ trans('Langcore::global.Login') }}
    </button>

    @if (Route::has('password.request'))
    <a href="{{ route('password.request') }}" id="forgot_pswd">{{ trans('Langcore::global.ForgotPassword') }}</a>
    @endif

    <hr>
    <button class="btn btn-primary btn-block" type="button" id="btn-signup" onclick="window.location.href='{{ route('members.web.register') }}'">
        <i class="fas fa-user-plus"></i> {{ trans('Langcore::global.Register') }}
    </button>
    {!! Form::close() !!}
</div>
@endsection
@section('footer')
@endsection