@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('InterfacePackage','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_interfacepackage_main')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')

{!!Form::open(['method' => 'POST', 'route' => 'interfacepackage.admin.config', 'enctype'=> 'multipart/form-data'])!!}
<div class="card card-accent-primary">
    <div class="card-body">
        <div class="form-group row">
            {!!Form::label('displayinterface', trans('Langcore::config.ConfigDisplay'),['class' =>'col-sm-3 col-form-label']);!!}
            <div class="col-sm-9">
                {!!Form::select('displayinterface', $configview, CFglobal::cfn('displayinterface','InterfacePackage'), ['class' => 'form-control', 'id'=>'displayinterface'])!!}
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