@extends('layouts.master')
@section('metatitle',transmod('sliders::Group'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_sliders_main')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/sliders/sliders.css.php') }}">
@endsection
@section('content')
<div id="managerslider">
    <div class="row">
        <div class="col-sm-4">
            @include('layouts.flash-message')
            <ul class="list-group">
                <li class="list-group-item p-0" aria-disabled="true">
                    <button type="button" class="btn btn-block btn-primary rounded-0" onclick="addgroup();">{!!transmod('sliders::AddGroup')!!}</button>
                </li>
                @foreach($groups as $group)
                <li class="list-group-item d-flex justify-content-between align-items-center" aria-disabled="true">
                    <div class="title" onclick="loadlistslider('{!!$group->id!!}');">
                        <strong>{!!$group->title!!}</strong>
                    </div>
                    <div class="button">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addgroup('{!!$group->id!!}');"><i class="fas fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="delgroup('{!!$group->id!!}');"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-8" id="listsliders"></div>
    </div>
</div>
@endsection
@section('footer')
<script src="{{ asset('modules/js/sliders/sliders.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="addgroup">
        </div>
    </div>
</div>
<script type="text/javascript">
    loadlistslider('{!!$groupid!!}');
</script>
@endsection