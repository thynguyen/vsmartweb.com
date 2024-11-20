@extends('layouts.master')
@section('metatitle',transmod('News::CatalogNews'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_news_category')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('listcategory',['id'=>$id])
@endsection
@section('footer')
<script src="{{ asset('modules/js/news/adminnews.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script type="text/javascript">
	var configdelcat = '{!!transmod('News::ConfirmDelCat')!!}';
</script>
@livewireScripts
@endsection