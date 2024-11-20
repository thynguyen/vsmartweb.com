<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}
    @LinkTheme()
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/style.css','theme') }}">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/style.responsive.css','theme') }}">
    <link rel="stylesheet" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/animate.css','theme') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/slidebars.min.css','theme') }}">
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/mobilemenu.css','theme') }}">

    @yield('header')
    @stack('link')
    {!! Assets::renderHeader() !!}
  </head>
  <body>