<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>@yield('metatitle')</title>
        <link rel="shortcut icon" href="{!!CFglobal::cfn('site_favicon')!!}" type="image/x-icon">
        <!-- Icons-->
        <link href="{{ themes('admindefault:css/coreui-icons.min.css') }}" rel="stylesheet">
        <link href="{{ themes('admindefault:css/flag-icon.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="{{ themes('admindefault:css/simple-line-icons.css') }}" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="{{ themes('admindefault:css/style.css') }}" rel="stylesheet">
        <link href="{{ themes('admindefault:css/pace.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/pnotify.custom.min.css') }}" rel="stylesheet">
    </head>
	<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
		<div class="card card-body">
			<div class="mb-3 row">
				<div class="col-sm-12">
					{!!Form::label('userinfo', trans('Langcore::global.Account'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('userinfo', null, ['class' => 'form-control','id'=>'userinfo']) !!}
				</div>
			</div>
			<div id="ajaxmember">
				@include('System.Permissions.ajaxlistmember')
			</div>
		</div>
		<script src="{{ themes('admindefault:js/jquery.min.js') }}"></script>
		<script src="{{ themes('admindefault:js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/modules/permission.js') }}"></script>
		<script type="text/javascript">$('#userinfo').on('keyup',function(){$value=$(this).val();$.ajax({type : 'get',url : '{{route('searchmember')}}',data:{_token: "<?php echo csrf_token(); ?>",'userinfo':$value},success:function(data){$('tbody').html(data.datamem);$('#memcount').text(data.memcount)}});}); $(document).ready(function(){$(document).on('click', '.pagination a',function(event){event.preventDefault(); $('li').removeClass('active'); $(this).parent('li').addClass('active'); var myurl=$(this).attr('href'); var page=$(this).attr('href').split('page=')[1]; getData(page,"#ajaxmember");});});</script>
	</body>
</html>