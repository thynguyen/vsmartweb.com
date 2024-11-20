@extends('layouts.master')
@section('metatitle',lang('content.config_global'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_configglobal')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/jquery.fonticonpicker.min.css') }}" rel="stylesheet">
<link href="{{ themes('admindefault:css/jquery.fonticonpicker.darkgrey.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => 'globalconfig', 'enctype'=> 'multipart/form-data'])!!}
{!! Form::hidden('site_logo', CFglobal::cfn('site_logo'), ['id'=>'site_logo', 'onchange'=>"uploadimg('#site_logo','#showlogo')"]) !!}
{!! Form::hidden('site_favicon', CFglobal::cfn('site_favicon'), ['id'=>'site_favicon', 'onchange'=>"uploadimg('#site_favicon','#showfavicon')"]) !!}
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#globalsite" role="tab" aria-controls="home"> <i class="fas fa-cogs"></i> {{trans('Langcore::global.GeneralInfo')}} </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#configemail" role="tab" aria-controls="profile"> <i class="far fa-envelope"></i> {{trans('Langcore::global.ConfigureSMTP')}}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#appsocial" role="tab" aria-controls="messages"> <i class="fas fa-share-alt"></i> {{trans('Langcore::global.Utilities')}}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#cacheredis" role="tab" aria-controls="messages"> <i class="fi fi-redis"></i> {{trans('Langcore::global.CacheDriver')}}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#capcha" role="tab" aria-controls="messages"> <i class="fab fa-creative-commons"></i> Capcha</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#follow" role="tab" aria-controls="follow"> <i class="fal fa-project-diagram"></i> {!!trans('Langcore::config.Follow')!!}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#extend" role="tab" aria-controls="extend"> <i class="fal fa-expand"></i> {!!trans('Langcore::global.Extend')!!}</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="globalsite" role="tabpanel">
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							{!!Form::label('site_url', trans('Langcore::global.SiteURL'));!!}
							{!! Form::text('env[APP_URL]', env('APP_URL','http://localhost'), ['class' => $errors->has('site_url') ? 'form-control is-invalid' : 'form-control','id'=>'site_url']) !!}
						</div>
						<div class="form-group">
							{!!Form::label('site_email', trans('Langcore::global.SiteEmail'), ['class' => 'form-col-form-label']);!!}
							{!! Form::text('site_email', CFglobal::cfn('site_email'), ['class' => $errors->has('site_email') ? 'form-control is-invalid' : 'form-control','id'=>'site_email']) !!}
						</div>
						<div class="form-group">
							{!!Form::label('site_phone', trans('Langcore::global.SitePhone'), ['class' => 'form-col-form-label']);!!}
							{!! Form::text('site_phone', CFglobal::cfn('site_phone'), ['class' => $errors->has('site_phone') ? 'form-control is-invalid' : 'form-control','id'=>'site_phone']) !!}
						</div>
						<div class="form-group">
							{!!Form::label('site_address', trans('Langcore::global.Address'), ['class' => 'form-col-form-label']);!!}
							{!! Form::text('site_address', CFglobal::cfn('site_address'), ['class' => $errors->has('site_address') ? 'form-control is-invalid' : 'form-control','id'=>'site_address']) !!}
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									{!!Form::label('site_latitude', trans('Langcore::config.SiteLatitude').' (lat)', ['class' => 'form-col-form-label']);!!}
									{!! Form::text('site_latitude', CFglobal::cfn('site_latitude'), ['class' => $errors->has('site_latitude') ? 'form-control is-invalid' : 'form-control','id'=>'site_latitude']) !!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									{!!Form::label('site_longitude', trans('Langcore::config.SiteLongitude').' (lng)', ['class' => 'form-col-form-label']);!!}
									{!! Form::text('site_longitude', CFglobal::cfn('site_longitude'), ['class' => $errors->has('site_longitude') ? 'form-control is-invalid' : 'form-control','id'=>'site_longitude']) !!}
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							{!!Form::label('adminprefix', trans('Langcore::config.AdminPrefix'), ['class' => 'form-col-form-label']);!!}
							{!! Form::text('env[ADMIN_PREFIX]', env('ADMIN_PREFIX','admin'), ['class' => 'form-control','id'=>'adminprefix']) !!}
						</div>
					</div>
					<div class="col-sm-4">
						<div class="row mb-2">
							<div class="col-md-6">
								{!!Form::label('theme', 'Logo', ['class' => 'form-col-form-label w-100 text-center font-weight-bold']);!!}
								<div class="d-block w-100 text-center border rounded p-2">
									<img src="{!!(CFglobal::cfn('site_logo'))?CFglobal::cfn('site_logo'):themes('img/noimage.png')!!}" id="showlogo" class="img-fluid">
								</div>
								{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmsitelogo','data-input'=>'site_logo','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=site_logo")'])!!}
							</div>
							<div class="col-md-6">
								{!!Form::label('theme', 'Favicon', ['class' => 'form-col-form-label w-100 text-center font-weight-bold']);!!}
								<div class="d-block w-100 text-center border rounded p-2">
									<img src="{!!(CFglobal::cfn('site_favicon'))?CFglobal::cfn('site_favicon'):themes('img/noimage.png')!!}" id="showfavicon" class="img-fluid">
								</div>
								{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmsitefavicon','data-input'=>'site_favicon','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=site_favicon")'])!!}
							</div>
						</div>
						<div class="form-group">
							{!!Form::label('admintheme', trans('Langcore::global.ThemeAdmin'), ['class' => 'form-col-form-label']);!!}
							{!!Form::select('admintheme', $adminthemes, CFglobal::cfn('admintheme'), ['class' => 'form-control', 'id'=>'admintheme'])!!}
						</div>
						<div class="form-group">
							{!!Form::label('environment', trans('Langcore::global.AppEnvironment'));!!}
							{!!Form::select('env[APP_ENV]', $select_app_env, env('APP_ENV','local'), ['class' => 'form-control'])!!}
						</div>
						<div class="form-group">
							{!!Form::label('site_closure_mode', trans('Langcore::config.SiteClosureMode'));!!}
							{!!Form::select('env[SITE_CLOSURE_MODE]', $close_site, env('SITE_CLOSURE_MODE',0), ['class' => 'form-control'])!!}
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-check checkbox">
									{!! Form::hidden('env[APP_DEBUG]', env('APP_DEBUG','true'), ['id'=>'val_app_debug']) !!}
									{!!Form::checkbox(null,1,(env('APP_DEBUG','true')==true)?true:false,['class'=>'form-check-input','id'=>'app_debug'])!!}
									{!!Form::label('app_debug', trans('Langcore::global.AppDebug'),['class'=>'form-check-label']);!!}
								</div>
								<div class="form-check checkbox">
									{!! Form::hidden('env[LARAVEL_PAGE_SPEED_ENABLE]', env('LARAVEL_PAGE_SPEED_ENABLE','true'), ['id'=>'val_laravel_page_speed']) !!}
									{!!Form::checkbox(null,1,(env('LARAVEL_PAGE_SPEED_ENABLE','true')==true)?true:false,['class'=>'form-check-input','id'=>'laravel_page_speed'])!!}
									{!!Form::label('laravel_page_speed', 'Minify HTML',['class'=>'form-check-label']);!!}
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-check checkbox">
									{!! Form::hidden('env[JS_MINIFIER]', env('JS_MINIFIER','true'), ['id'=>'val_js_minifier']) !!}
									{!!Form::checkbox(null,1,(env('JS_MINIFIER','true')==true)?true:false,['class'=>'form-check-input','id'=>'js_minifier'])!!}
									{!!Form::label('js_minifier', 'Minify JS',['class'=>'form-check-label']);!!}
								</div>
								<div class="form-check checkbox">
									{!! Form::hidden('env[CSS_MINIFIER]', env('CSS_MINIFIER','true'), ['id'=>'val_css_minifier']) !!}
									{!!Form::checkbox(null,1,(env('CSS_MINIFIER','true')==true)?true:false,['class'=>'form-check-input','id'=>'css_minifier'])!!}
									{!!Form::label('css_minifier', 'Minify CSS',['class'=>'form-check-label']);!!}
								</div>
							</div>
						</div>
						<hr>

						<div class="form-check checkbox">
							{!! Form::hidden('env[APP_URL_LANG]', env('APP_URL_LANG','true'), ['id'=>'val_app_url_lang']) !!}
							{!!Form::checkbox(null,1,(env('APP_URL_LANG','true')==true)?true:false,['class'=>'form-check-input','id'=>'app_url_lang'])!!}
							{!!Form::label('app_url_lang', trans('Langcore::config.DisableLangURL'),['class'=>'form-check-label']);!!}
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="configemail" role="tabpanel">
				<div class="form-group row">
					{!!Form::label('mail_driver', trans('Langcore::global.EmailProtocol'),['class'=>'col-md-2 col-form-label']);!!}
					<div class="col-md-10 col-form-label">
						@foreach($list_maildriver as $maildriver => $namemaildriver)
						<div class="mailradio_{{$maildriver}} form-check form-check-inline mr-2 border px-2 rounded {{(env('MAIL_DRIVER')==$maildriver)?'border-primary bg-primary text-white ':''}}">
							{!!Form::radio('env[MAIL_DRIVER]', $maildriver,(env('MAIL_DRIVER')==$maildriver)? true : false,['class' => 'form-check-input', 'id'=>'type_'.$maildriver]);!!}
							{!!Form::label('type_'.$maildriver, $namemaildriver, ['class' => 'form-check-label']);!!}
						</div>
						@endforeach
					</div>
				</div>
				<div id="maildriver_smtp" class="form_mail" style="{{(env('MAIL_DRIVER')=='smtp')?'':'display:none'}}">
					<div class="form-group">
						{!!Form::label('mail_host', 'SMTP Host');!!}
						{!! Form::text('env[MAIL_HOST]', env('MAIL_HOST','smtp.mailtrap.io'), ['class' => $errors->has('mail_host') ? 'form-control is-invalid' : 'form-control','id'=>'mail_host']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('mail_port', 'SMTP Port');!!}
						{!! Form::text('env[MAIL_PORT]', env('MAIL_PORT','2525'), ['class' => $errors->has('mail_port') ? 'form-control is-invalid' : 'form-control','id'=>'mail_port']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('mail_encryption', trans('Langcore::global.SMTPEncryption'));!!}
						{!!Form::select('env[MAIL_ENCRYPTION]', $mail_encryption, env('MAIL_ENCRYPTION'), ['class' => 'form-control', 'id'=>'mail_encryption'])!!}
					</div>
					<div class="form-group">
						{!!Form::label('mail_username', 'SMTP Username');!!}
						{!! Form::text('env[MAIL_USERNAME]', env('MAIL_USERNAME'), ['class' => $errors->has('mail_username') ? 'form-control is-invalid' : 'form-control','id'=>'mail_username']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('mail_password', 'SMTP Password');!!}
						{!! Form::text('env[MAIL_PASSWORD]', env('MAIL_PASSWORD'), ['class' => $errors->has('mail_password') ? 'form-control is-invalid' : 'form-control','id'=>'mail_password']) !!}
					</div>
				</div>
				<div id="maildriver_mailgun" class="form_mail" style="{{(env('MAIL_DRIVER')=='mailgun')?'':'display:none'}}">
					<div class="form-group">
						{!!Form::label('mailgun_domain', 'Mailgun Domain');!!}
						{!! Form::text('env[MAILGUN_DOMAIN]', env('MAILGUN_DOMAIN'), ['class' => $errors->has('mailgun_domain') ? 'form-control is-invalid' : 'form-control','id'=>'mailgun_domain']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('mailgun_secret', 'Mailgun Secret');!!}
						{!! Form::text('env[MAILGUN_SECRET]', env('MAILGUN_SECRET'), ['class' => $errors->has('mailgun_secret') ? 'form-control is-invalid' : 'form-control','id'=>'mailgun_secret']) !!}
					</div>
				</div>
				<div id="maildriver_sparkpost" class="form_mail" style="{{(env('MAIL_DRIVER')=='sparkpost')?'':'display:none'}}">
					<div class="form-group">
						{!!Form::label('sparkpost_secret', 'SparkPost Secret');!!}
						{!! Form::text('env[SPARKPOST_SECRET]', env('SPARKPOST_SECRET'), ['class' => $errors->has('sparkpost_secret') ? 'form-control is-invalid' : 'form-control','id'=>'sparkpost_secret']) !!}
					</div>
				</div>
				<div id="maildriver_sendinblue" class="form_mail" style="{{(env('MAIL_DRIVER')=='sendinblue')?'':'display:none'}}">
					<div class="form-group">
						{!!Form::label('sendinblue_key', 'Sendinblue Key');!!}
						{!! Form::text('env[SENDINBLUE_KEY]', env('SENDINBLUE_KEY'), ['class' => $errors->has('sendinblue_key') ? 'form-control is-invalid' : 'form-control','id'=>'sendinblue_key']) !!}
					</div>
				</div>
				<hr>
				<div class="form-group">
					{!!Form::label('email_address', 'Email gửi đi');!!}
					{!! Form::text('env[MAIL_FROM_ADDRESS]', env('MAIL_FROM_ADDRESS'), ['class' => $errors->has('email_address') ? 'form-control is-invalid' : 'form-control','id'=>'email_address']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('email_name', 'Tên hiển thị');!!}
					{!! Form::text('env[MAIL_FROM_NAME]', env('MAIL_FROM_NAME'), ['class' => $errors->has('email_name') ? 'form-control is-invalid' : 'form-control','id'=>'email_name']) !!}
				</div>
			</div>
			<div class="tab-pane" id="appsocial" role="tabpanel">
				<div class="card card-accent-primary rounded-0">
					<div class="card-body">
						<div class="form-group row mb-0">
							{!!Form::label('map_driver', trans('Langcore::config.MapDriver'), ['class' => 'col-sm-2 control-label']);!!}
							<div class="col-sm-10">
								@foreach($list_mapdriver as $mapdriver => $namemapdriver)
								<div class="mapradio_{{$mapdriver}} form-check form-check-inline mr-2 border px-2 rounded {{(env('MAP_DRIVER')==$mapdriver)?'border-primary bg-primary text-white ':''}}">
									{!!Form::radio('env[MAP_DRIVER]', $mapdriver,(env('MAP_DRIVER')==$mapdriver)? true : false,['class' => 'form-check-input', 'id'=>'type_'.$mapdriver]);!!}
									{!!Form::label('type_'.$mapdriver, $namemapdriver, ['class' => 'form-check-label']);!!}
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<div class="list-group" id="v-pills-tab" role="tablist" aria-orientation="vertical">
							<a class="list-group-item list-group-item-action active" id="v-pills-facebook-tab" data-toggle="pill" href="#v-pills-facebook" role="tab" aria-controls="v-pills-facebook" aria-selected="true">Facebook</a>
							<a class="list-group-item list-group-item-action" id="v-pills-google-tab" data-toggle="pill" href="#v-pills-google" role="tab" aria-controls="v-pills-google" aria-selected="true">Google</a>
							<a class="list-group-item list-group-item-action" id="v-pills-twitter-tab" data-toggle="pill" href="#v-pills-twitter" role="tab" aria-controls="v-pills-twitter" aria-selected="true">Twitter</a>
							<a class="list-group-item list-group-item-action form_map" id="v-pills-mapbox-tab" data-toggle="pill" href="#v-pills-mapbox" role="tab" aria-controls="v-pills-mapbox" aria-selected="true" style="{{(env('MAP_DRIVER')=='mapbox')?'':'display:none'}}">MapBox</a>
						</div>
					</div>
					<div class="col-9">
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-facebook" role="tabpanel" aria-labelledby="v-pills-facebook-tab">
								<div class="form-group">
									{!!Form::label('fb_client_id', 'Client ID');!!}
									{!! Form::text('env[FACEBOOK_CLIENT_ID]', env('FACEBOOK_CLIENT_ID'), ['class' => $errors->has('fb_client_id') ? 'form-control is-invalid' : 'form-control','id'=>'fb_client_id']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('fb_client_secret', 'Client Secret');!!}
									{!! Form::text('env[FACEBOOK_CLIENT_SECRET]', env('FACEBOOK_CLIENT_SECRET'), ['class' => $errors->has('fb_client_secret') ? 'form-control is-invalid' : 'form-control','id'=>'fb_client_secret']) !!}
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-google" role="tabpanel" aria-labelledby="v-pills-google-tab">
								<div class="form-group">
									{!!Form::label('gg_client_id', 'Client ID');!!}
									{!! Form::text('env[GOOGLE_CLIENT_ID]', env('GOOGLE_CLIENT_ID'), ['class' => $errors->has('gg_client_id') ? 'form-control is-invalid' : 'form-control','id'=>'gg_client_id']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('gg_client_secret', 'Client Secret');!!}
									{!! Form::text('env[GOOGLE_CLIENT_SECRET]', env('GOOGLE_CLIENT_SECRET'), ['class' => $errors->has('gg_client_secret') ? 'form-control is-invalid' : 'form-control','id'=>'gg_client_secret']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('analytics_code', 'ANALYTICS CODE');!!}
									{!! Form::text('env[ANALYTICS_CODE]', env('ANALYTICS_CODE'), ['class' => 'form-control','id'=>'analytics_code']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('analytics_view_id', 'ANALYTICS VIEW ID');!!}
									{!! Form::text('env[ANALYTICS_VIEW_ID]', env('ANALYTICS_VIEW_ID'), ['class' => (env('ANALYTICS_VIEW_ID') && !$fileanalyticsgg) ? 'form-control is-invalid' : 'form-control','id'=>'analytics_view_id']) !!}
									@if(env('ANALYTICS_VIEW_ID') && !$fileanalyticsgg)
									<div class="invalid-feedback">
										{{trans('Langcore::global.NoFileFoundGGAnalytics')}}
									</div>
									@endif
								</div>
								<div id="mapdriver_googlemap" class="form-group form_map" style="{{(env('MAP_DRIVER')=='googlemap')?'':'display:none'}}">
									{!!Form::label('gg_map_key', 'GOOGLE MAP KEY');!!}
									{!! Form::text('env[GOOGLE_MAP_KEY]', env('GOOGLE_MAP_KEY'), ['class' => $errors->has('gg_map_key') ? 'form-control is-invalid' : 'form-control','id'=>'gg_map_key']) !!}
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-twitter" role="tabpanel" aria-labelledby="v-pills-twitter-tab">
								<div class="form-group">
									{!!Form::label('tw_client_id', 'Client ID');!!}
									{!! Form::text('env[TWITTER_CLIENT_ID]', env('TWITTER_CLIENT_ID'), ['class' => $errors->has('tw_client_id') ? 'form-control is-invalid' : 'form-control','id'=>'tw_client_id']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('tw_client_secret', 'Client Secret');!!}
									{!! Form::text('env[TWITTER_CLIENT_SECRET]', env('TWITTER_CLIENT_SECRET'), ['class' => $errors->has('tw_client_secret') ? 'form-control is-invalid' : 'form-control','id'=>'tw_client_secret']) !!}
								</div>
								<div class="form-group">
									{!!Form::label('tw_site', 'Twitter site');!!}
									{!! Form::text('env[TWITTER_SITE]', str_replace('@', '', env('TWITTER_SITE')), ['class' => $errors->has('tw_site') ? 'form-control is-invalid' : 'form-control','id'=>'tw_site']) !!}
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-mapbox" role="tabpanel" aria-labelledby="v-pills-mapbox-tab">
								<div class="form-group form_map" id="mapdriver_mapbox" style="{{(env('MAP_DRIVER')=='mapbox')?'':'display:none'}}">
									{!!Html::decode(Form::label('mb_access_token', 'MAPBOX TOKEN <a href="https://account.mapbox.com/auth/signup/" target="_black">('.trans('Langcore::config.SignUpAPI').')</a>'));!!}
									{!! Form::text('env[MAPBOX_TOKEN]', env('MAPBOX_TOKEN'), ['class' => $errors->has('mb_access_token') ? 'form-control is-invalid' : 'form-control','id'=>'mb_access_token']) !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="cacheredis" role="tabpanel">
				<div class="form-group row">
					<label class="col-md-2 col-form-label">{{trans('Langcore::global.CacheDriver')}}</label>
					<div class="col-md-10 col-form-label">
						@foreach($list_cachedriver as $cachedriver => $namecachedriver)
							<div class="cacheradio_{{$cachedriver}} form-check form-check-inline mr-2 border px-2 rounded {{(env('CACHE_DRIVER')==$cachedriver)?'border-primary bg-primary text-white ':''}}">
								{!!Form::radio('env[CACHE_DRIVER]', $cachedriver,(env('CACHE_DRIVER')==$cachedriver)? true : false,['class' => 'form-check-input', 'id'=>'type_'.$cachedriver]);!!}
								{!!Form::label('type_'.$cachedriver, $namecachedriver, ['class' => 'form-check-label']);!!}
							</div>
						@endforeach
					</div>
				</div>
				<div class="form_cache" id="cachedriver_redis" style="{{(env('CACHE_DRIVER')=='redis')?'':'display:none'}}">
					<div class="form-group">
						{!!Form::label('redis_host', 'REDIS HOST');!!}
						{!! Form::text('env[REDIS_HOST]', env('REDIS_HOST'), ['class' => $errors->has('redis_host') ? 'form-control is-invalid' : 'form-control','id'=>'redis_host']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('redis_port', 'REDIS PORT');!!}
						{!! Form::number('env[REDIS_PORT]', env('REDIS_PORT'), ['class' => $errors->has('redis_port') ? 'form-control is-invalid' : 'form-control','id'=>'redis_port']) !!}
					</div>
					<div class="form-group">
						{!!Form::label('redis_pass', 'REDIS PASSWORD');!!}
						<input type="password" name="redis_pass" id="redis_pass" class="{{$errors->has('redis_pass') ? 'form-control is-invalid' : 'form-control'}}" value="{{env('REDIS_PASSWORD')}}">
					</div>
				</div>
			</div>
			<div class="tab-pane" id="capcha" role="tabpanel">
				<div class="form-group">
					{!!Form::label('capcha_sitekey', 'CAPTCHA SITEKEY');!!}
					{!! Form::text('env[RECAPTCHA_SITE_KEY]', env('RECAPTCHA_SITE_KEY'), ['class' => $errors->has('capcha_sitekey') ? 'form-control is-invalid' : 'form-control','id'=>'capcha_sitekey']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('capcha_secret', 'CAPTCHA SECRET');!!} <a href="https://www.google.com/recaptcha/about/" title="" target="_black">({!!trans('Langcore::config.SignUpAPI')!!})</a>
					{!! Form::text('env[RECAPTCHA_SECRET_KEY]', env('RECAPTCHA_SECRET_KEY'), ['class' => $errors->has('capcha_secret') ? 'form-control is-invalid' : 'form-control','id'=>'capcha_secret']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('capcha_version', 'CAPTCHA SITEKEY');!!}
					{!!Form::select('env[RECAPTCHA_VERSION]', ['v2'=>'v2','v3'=>'v3'], env('RECAPTCHA_VERSION'), ['class' => 'form-control', 'id'=>'capcha_version'])!!}
				</div>
			</div>
			<div class="tab-pane" id="follow" role="tabpanel">
				<button type="button" class="btn btn-block btn-primary" onclick="plusfollow()"><i class="fas fa-plus-circle"></i></button>
				<div id="listfollows" class="my-3">
					@if(!empty(CFglobal::cfn('follow'))&&CFglobal::cfn('follow')!='null')
					@foreach(json_decode(CFglobal::cfn('follow'),true) as $key => $follow)
					<div class="d-block border p-3 mb-3 follow{!!$key!!}">
			    		<div class="row">
			    			<div class="col-sm-2 text-center">
								<div id="follow_icon{!!$key!!}">{!!AdminFunc::GetListIcons($follow['icon'],'geticonvalue'.$key,'follow['.$key.'][icon]')!!}</div>
								<button type="button" class="btn btn-sm btn-danger mt-3" onclick="deletefollow('follow{!!$key!!}')"><i class="fal fa-trash-alt"></i></button>
			    			</div>
			    			<div class="col-sm-10">
						    	<div class="form-group row">
					                <label for="follow_title{!!$key!!}" class="col-md-2 col-form-label">{!!trans('Langcore::global.Title')!!}</label>
					                <div class="col-md-10">
					                    {!! Form::text('follow['.$key.'][title]', $follow['title'], ['class' => 'form-control','id'=>'follow_title'.$key]) !!}
					                </div>
					            </div>
						    	<div class="form-group row">
					                <label for="follow_link{!!$key!!}" class="col-md-2 col-form-label">Link</label>
					                <div class="col-md-10">
					                    {!! Form::text('follow['.$key.'][link]', $follow['link'], ['class' => 'form-control','id'=>'follow_link'.$key]) !!}
					                </div>
					            </div>
			    			</div>
			    		</div>
			    	</div>
					@endforeach
					@endif
				</div>
				<button type="button" class="btn btn-block btn-primary" onclick="plusfollow()"><i class="fas fa-plus-circle"></i></button>
			</div>
			<div class="tab-pane" id="extend" role="tabpanel">
				<div class="form-group">
					{!!Form::label('extend_head', 'Head');!!}
					{!! Form::textarea('extend_head', CFglobal::cfn('extend_head'), ['class' => $errors->has('extend_head') ? 'form-control is-invalid' : 'form-control','id'=>'extend_head','rows'=>3]) !!}
				</div>
				<div class="form-group">
					{!!Form::label('extend_footer', 'Footer');!!}
					{!! Form::textarea('extend_footer', CFglobal::cfn('extend_footer'), ['class' => $errors->has('extend_footer') ? 'form-control is-invalid' : 'form-control','id'=>'extend_footer','rows'=>3]) !!}
				</div>
			</div>
		</div>
		<div class="card mt-3">
			<div class="card-body">
				<button class="btn btn-sm btn-primary" type="submit">
					<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
				</button>
			</div>
		</div>
{!! Form::close() !!}
@endsection
@section('footer')
<script src="{{ themes('admindefault:js/jquery.fonticonpicker.min.js') }}"></script>
<script type="text/javascript">
    $("input[name='env[MAIL_DRIVER]']").change(function(){
        var maildriver = $(this).val();
        $(".form_mail").hide();
        $("#maildriver_"+maildriver).show();
        $('[class*="mailradio"]').removeClass( "border-primary bg-primary text-white" );
        $(".mailradio_"+maildriver).addClass( "border-primary bg-primary text-white" );
    });
    $("input[name='env[CACHE_DRIVER]']").change(function(){
        var cachedriver = $(this).val();
        $(".form_cache").hide();
        $("#cachedriver_"+cachedriver).show();
        $('[class*="cacheradio"]').removeClass( "border-primary bg-primary text-white" );
        $(".cacheradio_"+cachedriver).addClass( "border-primary bg-primary text-white" );
    });
    $("input[name='env[MAP_DRIVER]']").change(function(){
        var mapdriver = $(this).val();
        $(".form_map").hide();
        $("#mapdriver_"+mapdriver).show();
        $("#v-pills-"+mapdriver+"-tab").show();
    });
    $('input[type=checkbox]').click(function(){
    	id = $(this).attr('id');
    	valid = '#val_'+id;
    	if ($(this).is(':checked')) {
        	$(valid).val('cfg_yes');
    	} else {
        	$(valid).val('cfg_no');
        }
    });
    var numrow = {!!(CFglobal::cfn('follow')&&CFglobal::cfn('follow')!='null')?count(json_decode(CFglobal::cfn('follow'),true)):0!!};
    function plusfollow(){
    	numrow++;
    	var geticon = getrouteicon('geticonvalue'+numrow,'follow['+numrow+'][icon]','follow_icon'+numrow);
    	div = '<div class="d-block border p-3 mb-3 follow'+numrow+'">\
    		<div class="row">\
    			<div class="col-sm-2 text-center">\
					<div id="follow_icon'+numrow+'"></div>\
					<button type="button" class="btn btn-sm btn-danger mt-3" onclick="deletefollow(\'follow'+numrow+'\')"><i class="fal fa-trash-alt"></i></button>\
    			</div>\
    			<div class="col-sm-10">\
			    	<div class="form-group row">\
		                <label for="follow_title'+numrow+'" class="col-md-2 col-form-label">{!!trans('Langcore::global.Title')!!}</label>\
		                <div class="col-md-10">\
		                    <input class="form-control" id="follow_title'+numrow+'" name="follow['+numrow+'][title]" type="text">\
		                </div>\
		            </div>\
			    	<div class="form-group row">\
		                <label for="follow_link'+numrow+'" class="col-md-2 col-form-label">Link</label>\
		                <div class="col-md-10">\
		                    <input class="form-control" id="follow_link'+numrow+'" name="follow['+numrow+'][link]" type="text">\
		                </div>\
		            </div>\
    			</div>\
    		</div>\
    	</div>';
    	$('#listfollows').append(div);
    }
    function getrouteicon(idkey,name,showicon){
    	$.ajax({
	        type : 'GET',
	        url : route('getlisticon',{idkey:idkey,name:name}),
	        data : '',
	        success : function(data) {
	            $('#'+showicon).html(data);
			    $('#'+idkey).fontIconPicker({
			        theme: 'fip-darkgrey'
			    });
	        }
	    });
    }
    function deletefollow(idkey){
        $('.'+idkey).remove();
    }
</script>
@if(!empty(CFglobal::cfn('follow'))&&CFglobal::cfn('follow')!='null')
<script type="text/javascript">
	@foreach(json_decode(CFglobal::cfn('follow'),true) as $key => $follow)
    $('#geticonvalue{!!$key!!}').fontIconPicker({
        theme: 'fip-darkgrey'
    });
    @endforeach
</script>
@endif
@endsection