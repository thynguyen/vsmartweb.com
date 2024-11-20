<!doctype html>
<html lang="{{ str_replace('_', '-', LaravelLocalization::getCurrentLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#0d6efd" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    @LinkTheme()
    
    <link href="https://fonts.googleapis.com/css?family=Questrial&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/style.css','theme') }}">
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/responsive.css','theme') }}">

    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/vendor/jside-menu.css','theme') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">

    @yield('header')
    @stack('link')
    {!! Assets::renderHeader() !!}
  </head>
  <body>