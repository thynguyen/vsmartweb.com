<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{trans('Langcore::global.Login').' - '.CFglobal::cfn('sitename')}}</title>
  <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ themes('admindefault:css/login.css') }}">
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 d-flex formlogin">
          <div class="login-wrapper m-auto">
            <div class="brand-wrapper"><img src="{{ asset('images/logo_vsw.png') }}" alt="{!!CFglobal::cfn('sitename')!!}" class="logo"></div>
            <p class="login-description">{{ trans('Langcore::global.Login') }} {!!trans('Langcore::permissions.Administrators')!!}</p>
            {!!Form::open(['method' => 'POST', 'route' => 'adminlogin', 'enctype'=> 'multipart/form-data','class'=>'login100-form validate-form'])!!}
                    @include('layouts.flash-message')
              <div class="form-group">
                <label for="email" class="sr-only">{!!trans('Langcore::global.Login_username')!!}</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                  </div>
                  {!! Form::text('username', old('username'), ['class' =>'form-control','id'=>'username','placeholder'=>trans('Langcore::global.Login_username')]) !!}
                </div>
                @if ($errors->has('username'))
                <small class="text-danger">{{ $errors->first('username') }}</small>
                @endif
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">{!!trans('Langcore::global.Password')!!}</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                  </div>
                  {!! Form::password('password', ['class' => 'form-control','id'=>'password','placeholder'=>trans('Langcore::global.Password')]) !!}
                </div>
                @if ($errors->has('password'))
                <small class="text-danger">{{ $errors->first('password') }}</small>
                @endif
              </div>
              <div class="form-options-wrapper">
                <div class="custom-control custom-checkbox login-check-box">
                  <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="remember">{{ trans('Langcore::global.Remember_me') }}</label>
                </div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password-link">{{ trans('Langcore::global.ForgotPassword') }}</a>
                @endif
              </div>
              <button class="btn btn-block login-btn">{{ trans('Langcore::global.Login') }}</button>
            {!! Form::close() !!}
            @if(count(LanguageFunc::GetAllLang())>=2)
            <nav class="social-links">
              @foreach (LanguageFunc::GetAllLang() as $lang)
              <a hreflang="{{ $lang['locale'] }}" href="{{ LaravelLocalization::getLocalizedURL($lang['locale'], null, [], true) }}" class="flex-c-m m-r-5"><img src="{{ asset('images/flags/'. strtoupper($lang['flag']) .'.png') }}" alt="{{ $lang['name'] }}" width="36px" class="p-1 border" /></a>
              @endforeach
            </nav>
            @endif
          </div>
          <div class="version">
            <a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" target="_black">{{config('app.vswver')}}</a>
            <span>&copy; All Rights Reserved.</span>
          </div>
        </div>
        <div class="col-lg-7 px-0 d-none d-lg-block">
          <img src="" alt="{!!CFglobal::cfn('sitename')!!}" class="login-img">
        </div>
      </div>
    </div>
  </main>
  <script src="{{ themes('admindefault:js/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script type="text/javascript">
      $(document).ready(function() {
        var images = ['{{ themes('admindefault:img/bg-01.jpg') }}', '{{ themes('admindefault:img/bg-02.jpg') }}', '{{ themes('admindefault:img/bg-03.jpg') }}', '{{ themes('admindefault:img/bg-04.jpg') }}', '{{ themes('admindefault:img/bg-05.jpg') }}'];
        $('.login-img').attr('src',images[Math.floor(Math.random() * images.length)]);
      });
  </script>
</body>
</html>
