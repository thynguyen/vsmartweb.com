<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('errortitle')</title>
  <link rel="shortcut icon" href="{!!CFglobal::cfn('site_favicon')!!}" type="image/x-icon">
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/style.css','theme') }}">
  <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/responsive.css','theme') }}">
  <link type="text/css" rel="stylesheet" href="{{ asset('css/errorlicense.css') }}" />
</head>
<body>