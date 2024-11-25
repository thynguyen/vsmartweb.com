@extends('layouts.master')
@section('metatitle',$group->title)
@section('breadcrumbs')
{{Breadcrumbs::render('module_pages_group',$group)}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('pagesgroup',['groupid'=>$group->id])
@endsection
@section('footer')
@livewireScripts
@endsection