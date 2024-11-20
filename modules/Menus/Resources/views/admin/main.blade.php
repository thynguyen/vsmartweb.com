@extends('layouts.master')
@section('metatitle',transmod('Menus::block_menu'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_menus_main')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/menus/adminmenus.css.php') }}">
<link href="{{ themes('admindefault:css/jquery.fonticonpicker.min.css') }}" rel="stylesheet">
<link href="{{ themes('admindefault:css/jquery.fonticonpicker.darkgrey.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<div id="managermenu">
    <div class="row">
        <div class="col-sm-4">
            <ul class="list-group mb-3">
                <li class="list-group-item p-0 mb-2" aria-disabled="true">
                    <button type="button" class="btn btn-block btn-primary rounded-0" onclick="addgroup();">{{transmod('Menus::add_block_menu')}}</button>
                </li>
                @foreach($groups as $group)
                <li class="list-group-item d-flex justify-content-between align-items-center" aria-disabled="true">
                    <div class="title" onclick="loadlistmenu('{!!$group->id!!}');">
                        <strong>{!!$group->title!!}</strong> <small class="text-danger font-weight-bold">({!!$group->menu->count()!!})</small>
                    </div>
                    <div class="button">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addgroup('{!!$group->id!!}');"><i class="fas fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="delgroup('{!!$group->id!!}');"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-8">
        	<div id="listmenus" class="showpanel"></div>
        	<div id="formcreatemenu"></div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script src="{{ asset('modules/js/menus/adminmenus.js.php') }}"></script>
<script src="{{ themes('admindefault:js/jquery.fonticonpicker.min.js') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="addgroup">
        </div>
    </div>
</div>
<script type="text/javascript">
    loadlistmenu('{!!$groupid!!}');
</script>
@endsection