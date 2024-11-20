@extends('layouts.master')
@section('metatitle',trans('Langcore::global.filemanager'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_filemanager')}}
@endsection
@section('content')
<iframe src="{{URL::to('/')}}/filemanager/dialog.php?akey={{session('akayfilemanager')}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
@endsection