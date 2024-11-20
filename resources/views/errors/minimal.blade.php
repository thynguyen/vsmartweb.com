<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{!!CFglobal::cfn('site_favicon')!!}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,900" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="{{ asset('css/errorlicense.css') }}" />

</head>

<body>

  <div id="notfound">
    <div class="notfound">
      <div class="notfound-404">
        <h1 class="error">@yield('code')</h1>
      </div>
      <h2>@yield('message')</h2>
      <a href="{{route('indexhome')}}" title="{{trans('Langcore::global.home')}}">{{trans('Langcore::global.home')}}</a>
    </div>
  </div>

</body>

</html>