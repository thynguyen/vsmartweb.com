@extends('layouts.master')
@section('metatitle',trans('Langcore::language.AddLang'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_addlang')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method'=>'POST','route'=>['addlang','id'=>$lang['id']],'enctype'=>'multipart/form-data'])!!}
{!! Form::hidden('script', ($locale)?$locale['script']:$lang['script'], ['id'=>'script']) !!}
{!! Form::hidden('name', ($locale)?$locale['name']:$lang['name'], ['id'=>'name']) !!}
<div class="card">
	<div class="card-body">
		@if(!$lang)
		<div class="form-group row">
			{!!Form::label('country',trans('Langcore::language.SelectLang'),['class'=>'col-md-2 col-form-label'])!!}
			<div class="col-md-10">
				<select class="form-control" id="getcountry" onchange="getlang('{{route('getlang')}}')" {{($lang)?'disabled':''}}>
					@foreach(LanguageFunc::GetCountry() as $key => $country)
					<option value="{!!$country['regional']!!}" {{($country['regional'] == $selectcountry)?'selected="selected"':''}}>{!!$country['native']!!} ({!!$country['regional']!!})</option>
					@endforeach
				</select>
				<span class="help-block text-success" id="findlang"></span>
			</div>
		</div>
		@endif
		<div class="form-group row">
			{!!Form::label('native',trans('Langcore::language.LangName'),['class'=>'col-md-2 col-form-label'])!!}
			<div class="col-md-10">
				{!!Form::text('native',($locale)?$locale['native']:$lang['native'],['class'=>'form-control','id'=>'native'])!!}
			</div>
		</div>
		@if($lang)
		{!!Form::hidden('locale',($locale)?$locale['locale']:$lang['locale'])!!}
		{!!Form::hidden('regional',($locale)?$locale['regional']:$lang['regional'])!!}
		{!!Form::hidden('flag',$selectflag)!!}
		@else
		<div class="form-group row">
			{!!Form::label('locale','Locale',['class'=>'col-md-2 col-form-label'])!!}
			<div class="col-md-10">
				{!!Form::text('locale',($locale)?$locale['locale']:$lang['locale'],['class'=>'form-control','id'=>'locale'])!!}
			</div>
		</div>
		<div class="form-group row">
			{!!Form::label('regional',trans('Langcore::language.LangCode'),['class'=>'col-md-2 col-form-label'])!!}
			<div class="col-md-10">
				{!!Form::text('regional',($locale)?$locale['regional']:$lang['regional'],['class'=>'form-control','id'=>'regional'])!!}
			</div>
		</div>
		<div class="form-group row">
			{!!Form::label('flag',trans('Langcore::language.LangFlag'),['class'=>'col-md-2 col-form-label'])!!}
			<div class="col-md-10">
				<select class="form-control" name="flag" id="flag">
					<option></option>
					@foreach(LanguageFunc::GetFlagAll() as $flag)
					<option value="{!!$flag['flag']!!}" {!!($flag['flag'] == $selectflag)?'selected="selected"':''!!}>{!!$flag['name']!!}</option>
					@endforeach
				</select>
			</div>
		</div>
		@endif
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
@section('footer')
<script type="text/javascript">
  var baseUrl = "{{ asset('images/flags') }}", placeholder = "{!!trans('Langcore::language.NoteSelectFlag')!!}";
</script>
<script src="{{ asset('js/modules/language.js') }}"></script>
@endsection