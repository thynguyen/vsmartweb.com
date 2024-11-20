@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Testimonials','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_testimonials_main')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('testimonials')
@endsection
@section('footer')
<script src="{{ asset('modules/js/testimonials/admintestimonials.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script type="text/javascript">
	var configdeltestimonial = '{!!transmod('Testimonials::NoteDelTestimonial')!!}';
</script>
@livewireScripts
@endsection