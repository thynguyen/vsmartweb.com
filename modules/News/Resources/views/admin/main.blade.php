@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('News','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_news_main')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('news',['area'=>'admin'])
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
	var configdelnew = '{!!transmod('News::ConfirmDelNew')!!}';
</script>
@livewireScripts
@endsection