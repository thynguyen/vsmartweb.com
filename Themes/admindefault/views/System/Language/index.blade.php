@extends('layouts.master')
@section('metatitle',trans('Langcore::language.Language'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_listlang')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/modules/language.css') }}" rel="stylesheet">
@endsection
@section('content')
<button class="btn btn-brand btn-sm btn-css3" type="button" style="margin-bottom: 4px" onclick="redirectroute('{{ route('addlang') }}')">
    <i class="fas fa-plus-square"></i>
    <span>{{trans('Langcore::language.AddLang')}}</span>
</button>
@include('layouts.flash-message')
<div class="card card-body">
	<table class="table table-responsive-sm table-striped table-sm">
		<thead>
			<tr>
				<th class="text-center" width="80"></th>
				<th>{!!trans('Langcore::language.LangName')!!}</th>
				<th class="text-center">Locale</th>
				<th class="text-center">{!!trans('Langcore::language.LangCode')!!}</th>
				<th class="text-center">{!!trans('Langcore::language.LangFlag')!!}</th>
				<th class="text-center">{!!trans('Langcore::language.LangDefault')!!}</th>
				<th class="text-center">{!!trans('Langcore::language.LangActive')!!}</th>
				<th class="text-center">{!!trans('Langcore::language.TranslateLang')!!}</th>
				<th class="text-center">{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($alllang as $key => $lang)
			<tr>
				<td class="text-center">
					<select class="form-control" id="idweight_{{$lang['id']}}" onchange="changeweightsys('{{ route('changelangweight',$lang['id']) }}','idweight_{{$lang['id']}}','tbody','.navbar-nav')">
						@for($i=1;$i<=$num;$i++)
						<option value="{!!$i!!}" {{($i==$lang['weight'])?'selected="selected"':''}}>{!!$i!!}</option>
						@endfor
					</select>
				</td>
				<td>{!!$lang['native']!!}</td>
				<td class="text-center">{!!$lang['locale']!!}</td>
				<td class="text-center">{!!$lang['regional']!!}</td>
				<td class="text-center"><img src="{{ asset('images/flags/'. $lang['flag'] .'.png') }}" alt="{!!$lang['name']!!}" width="22px" /></td>
				<td class="text-center">
					@if($lang['default']==1)
						<span class="text-danger"><i class="fas fa-star"></i></span>
					@else
						<button type="button" class="set-default" onclick="actionsys('{{ route('defaultlang',$lang['id']) }}','tbody');"><i class="fas fa-star"></i></button>
					@endif
				</td>
				<td class="text-center">
					<label class="switch switch-pill switch-outline-primary-alt switch-sm align-middle mb-0">
						<input class="switch-input" type="checkbox"  onchange="actionsys('{{ route('activelang',$lang['id']) }}','tbody','.navbar-nav');" {{($lang['active'])? 'checked=""':''}}>
						<span class="switch-slider"></span>
					</label>
				</td>
				<td class="text-center">
					<button class="btn btn-sm btn-link" type="button" onclick="redirectroute('{{ route('translatelang',['locale'=>$lang['locale']]) }}')"><i class="fas fa-language fa-2x"></i></button>
				</td>
				<td class="text-center">
					<div class="btn-group">
						<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{ route('addlang',['id'=>$lang['id']]) }}')"><i class="fas fa-edit"></i></button>
						<button class="btn btn-sm btn-danger active"type="button" onclick="deletesys('{{route('dellang',['id'=>$lang['id'],'locale'=>$lang['locale']])}}','tbody','.navbar-nav','{{trans('Langcore::global.warning_delfile')}}')" {!!(LaravelLocalization::getCurrentLocale() == $lang['locale'])?'disabled':''!!}><i class="fas fa-trash-alt"></i></button>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('footer')
@endsection