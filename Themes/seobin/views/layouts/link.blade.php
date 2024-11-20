<!doctype html>
<html lang="{{ str_replace('_', '-', LaravelLocalization::getCurrentLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    @LinkTheme()
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/icofonts.css','theme') }}">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/magnific-popup.css','theme') }}">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/style.css','theme') }}">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/responsive.css','theme') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    @yield('header')
    @stack('link')
    {!! Assets::renderHeader() !!}
  </head>
  <body>