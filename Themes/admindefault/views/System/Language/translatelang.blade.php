@extends('layouts.master')
@section('metatitle',trans('Langcore::language.TranslateLang'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_translatelang')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/modules/language.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-editable.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card card-body">
	<div class="row">
		<div class="col-sm-4">
			<select id="getlocale" class="form-control" onchange="getfilelang('{{route('translatelang')}}','#getlocale')">
				@foreach($alllang as $key => $loca)
					<option value="{{$loca['locale']}}" {{($locale == $loca['locale'])?'selected="selected"': ''}}>{{$loca['name']}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-4">
			<select id="getviewfile" class="form-control" onchange="getfilelang('{{route('translatelang',['locale'=>$locale])}}','#getviewfile')">
				@foreach($groups as $key => $file)
					<option value="{{$file}}" {{($group == $file)?'selected="selected"': ''}}>{{$file}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-sm-4 text-right">
			<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{$addkeylang}}')">{!!trans('Langcore::language.AddKeyLang')!!}</button>
		</div>
	</div>
</div>
<div class="card card-body">
	<table class="table table-responsive-sm table-striped">
		<thead>
			<tr>
				<th class="bg-primary" width="200">Key</th>
				@foreach($locales as $locale)
				<th width="350">
					<img src="{{ asset('images/flags/'. LanguageFunc::GetLocale('locale',$locale)['flag'] .'.png') }}" alt="{!!$locale!!}" width="22px" />
					<button class="btn btn-brand btn-sm btn-twitter" type="button" onclick="exportlang('{{route('exportlang',['locale'=>$locale])}}')">
					<i class="fas fa-file-export"></i>
					<span>{!!trans('Langcore::global.ExportFile')!!}</span>
					</button>
				</th>
				@endforeach
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($showcontenlang as $keylang => $value)
			<tr id="{!!$group!!}">
				<td class="bg-primary">{!!$keylang!!}</td>
				@foreach($locales as $key => $locale)
				<td>
				<a href="#edit" id="username" class="editable status-0 locale-{!!$locale!!}" data-locale="{!!$locale!!}" data-type="textarea" data-name="{!!$locale!!}|{!!$keylang!!}" data-pk="0" data-url="{{$routeeditlang}}">{!!(isset($value[$locale]))?$value[$locale]['value']:''!!}</a>
				</td>
				@endforeach
				<td>
					<button class="btn btn-danger btn-sm" type="button" onclick="deletesys('{{route('delkeylang',['group'=>$group,'key'=>$keylang])}}','tbody','','{{trans('Langcore::global.warning_delfile')}}')"><i class="fas fa-trash-alt"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('footer')
<script type="text/javascript">
	var baseUrl = "{{ asset('images/flags') }}",
	    placeholder = "{!!trans('Langcore::language.ChooseLanguage')!!}";
	$("select").select2({
	    theme: "bootstrap",
	    language: langsite
	});
	jQuery(document).ready(function($){
		$.ajaxSetup({
		    beforeSend: function(xhr, settings) {
		        console.log('beforesend');
		        settings.data += "&_token=<?php echo csrf_token() ?>";
		    }
		});
		$('.editable').editable().on('hidden', function(e, reason){
		    var locale = $(this).data('locale');
		    if(reason === 'save'){
		        $(this).removeClass('status-0').addClass('status-1');
		    }
		    if(reason === 'save' || reason === 'nochange') {
		        var $next = $(this).closest('tr').next().find('.editable.locale-'+locale);
		        setTimeout(function() {
		            $next.editable('show');
		        }, 300);
		    }
		});
	});
</script>
<script src="{{ asset('js/bootstrap-editable/bootstrap-editable.min.js') }}"></script>
<script src="{{ asset('js/modules/language.js') }}"></script>
@endsection