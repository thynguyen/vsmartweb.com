@extends('layouts.master')
@section('metatitle',trans('Langcore::themes.LayoutSetup'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_layoutsetup_themes')}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/themes.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method'=>'POST','route'=>['layoutsetup'],'enctype'=>'multipart/form-data'])!!}
<h5 class="mb-3"><i class="fas fa-dice-d20 mr-2"></i>{!!CFglobal::cfn('theme')!!}</h5>
<div class="row mb-2 px-3">
	@foreach($listmod as $modname => $modfunc)
	@if($modfunc or $modname == 'Index-Home' )
	<div class="col-lg-4 m-0 p-0 card card-accent-primary rounded-0">
		<div class="card-header">
			<h6>{!!$modname!!}</h6>
		</div>
		<div class="card-body p-1">
				@if($modname == 'Index-Home')
				<div class="border m-1 p-2 d-flex justify-content-between align-items-center">
					<div class="">
						{{trans('Langcore::global.home')}}
					</div>
					<div class="">
						<select class="form-control-sm" name="func[0]">
							@foreach($listlayout as $layout)
							<option value="{!!$layout['covername']!!}" {{(ThemesFunc::GetLS(0,$layout['covername']) == $layout['covername'])?'selected="selected"':''}}>{!!$layout['covername']!!} </option>
							@endforeach
						</select>
					</div>
				</div>
				@endif
				@foreach($modfunc as $funcinfo)
				<div class="border m-1 p-2 d-flex justify-content-between align-items-center">
					<div class="">
						{!!$funcinfo['func_custom_name']!!}
					</div>
					<div class="">
						<select class="form-control-sm" name="func[{!!$funcinfo['id']!!}]">
							@foreach($listlayout as $layout)
							<option value="{!!$layout['covername']!!}" {{(ThemesFunc::GetLS($funcinfo['id'],$layout['covername']) == $layout['covername'])?'selected="selected"':''}}>{!!$layout['covername']!!} </option>
							@endforeach
						</select>
					</div>
				</div>
				@endforeach
		</div>
	</div>
	@endif
	@endforeach
</div>
<div class="card">
	<div class="card-body text-center">
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> Lưu lại
		</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
@section('footer')
@endsection