@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('News','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_news_main')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('news',['area'=>'web-viewlistcat'])
@livewire('listcatnews')
@endsection
@section('footer')
@livewireScripts
@endsection