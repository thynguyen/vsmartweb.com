@extends('layouts.master')
@section('metatitle',trans('Langcore::config.ConfigModule'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_news_config')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => 'news.admin.config', 'enctype'=> 'multipart/form-data'])!!}
<div class="card card-accent-primary">
    <div class="card-body">
        <div class="form-group row">
            {!!Form::label('displaynews', trans('Langcore::config.ConfigDisplay'),['class' =>'col-sm-3 col-form-label']);!!}
            <div class="col-sm-9">
                {!!Form::select('displaynews', $configview, CFglobal::cfn('displaynews','News'), ['class' => 'form-control', 'id'=>'displaynews'])!!}
            </div>
        </div>
        <div class="form-group row">
            {!!Form::label('perpage_new', transmod('News::DisplayedOnPage'),['class' =>'col-sm-3 col-form-label']);!!}
            <div class="col-sm-9">
                {!! Form::text('perpage_new', CFglobal::cfn('perpage_new','News'), ['class' => 'form-control','id'=>'perpage_new']) !!}
            </div>
        </div>
        <div class="form-group row">
            {!!Form::label('perpagecat_new', transmod('News::ShowOnCatalog'),['class' =>'col-sm-3 col-form-label']);!!}
            <div class="col-sm-9">
                {!! Form::text('perpagecat_new', CFglobal::cfn('perpagecat_new','News'), ['class' => 'form-control','id'=>'perpagecat_new']) !!}
            </div>
        </div>
        <button class="btn btn-sm btn-primary" type="submit">
            <i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
        </button>
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
@endsection