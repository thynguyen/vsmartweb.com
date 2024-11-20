@extends('layouts.master')
@section('metatitle',trans('Langcore::global.home'))
@section('breadcrumbs')
{{Breadcrumbs::render('sitehome')}}
@endsection
@section('header')
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/vendor/owl.carousel.min.css','theme') }}">
    <link rel="stylesheet" type="text/css" href="{{ ThemesFunc::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/vendor/owl.theme.default.min.css','theme') }}">
@endsection
@section('content')
@WidgetPlace('home')
@endsection
@section('footer')
    <script type="text/javascript" src="{{ ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('theme').'/assets/js/vendor/owl.carousel.min.js','theme') }}"></script>
@endsection