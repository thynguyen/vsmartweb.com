@extends('layouts.master')
@section('metatitle',trans('Langcore::licenses.ManageVersions'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_manageversions')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		@livewire('listversions')
	</div>
</div>
@endsection
@section('footer')
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script src="{{ asset('js/modules/licenses.js') }}"></script>
<script type="text/javascript">
	var numrow = 0;
</script>
@livewireScripts
@endsection