@extends('layouts.master')
@section('metatitle',$title)
@section('breadcrumbs')
{{Breadcrumbs::render('admin_news_addnew',$new)}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/jquery.scrollbar.css') }}" rel="stylesheet">
<link href="{{ themes('admindefault:css/jquery.tag-editor.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['news.admin.addnew','id'=>($new)?$new->id:'null'], 'enctype'=> 'multipart/form-data'])!!}
@if($new)
{!! Form::hidden('title_old', $new['title'], ['id'=>'title_old']) !!}
{!! Form::hidden('slug_old', $new['slug'], ['id'=>'slug_old']) !!}
@endif
<div class="row">
	<div class="col-sm-9">
		<div class="card">
			<div class="card-body">
				<div class="form-group row">
					{!!Form::label('title', trans('Langcore::global.Title'),['class' =>'col-sm-2 col-form-label']);!!}
					<div class="col-sm-10">
						{!! Form::text('title', ($new['title'])?$new['title']:'', ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control checktitleslug','id'=>'title','onkeyup'=>'ChangeToSlug("title","slug","showslug")']) !!}
						@if ($errors->has('title'))
		                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
		                @endif
		                <small class="error-title"></small>
	                </div>
				</div>
				<div class="form-group row">
					{!!Form::label('slug', 'URL Slug',['class' =>'col-sm-2 col-form-label']);!!}
					<div class="col-sm-10">
						<div class="form-control h-auto {{$errors->has('slug') ? 'is-invalid' : ''}}">
							{{url('/').'/'.AdminFunc::GetPrefixMod('News').'/'}}
							{!! Form::hidden('slug', ($new)?$new->slug->slug:'', ['class' => 'w-50 d-inline-block checktitleslug','id'=>'slug','onkeyup'=>'ChangeInputSlug("showslug")']) !!}
							<span id="showslug">{{($new)?$new->slug->slug:''}}</span>.html <button id="showinput" onclick="BTshowIPSlug('slug','showslug','showinput')" type="button" class="ml-2 btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
						</div>
						@if ($errors->has('slug'))
		                <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
		                @endif
		                <small class="error-slug"></small>
	                </div>
				</div>
				<div class="form-group position-relative">
					{!!Form::label('description', trans('Langcore::global.Description'),['class' =>'col-form-label']);!!}
					{!! Form::textarea('description', ($new['description'])?$new['description']:'', ['class' => 'form-control','id'=>'description','rows'=>4,'onKeyDown'=>'return text_length("description","desclength" ,350)','onKeyUp'=>'return text_length("description","desclength" ,350)']) !!}
					<small style="position: absolute;top: 10px;right: 5px;"><span id="desclength">{{($new['description'])?350-mb_strlen($new['description']):350}}</span> {{trans('Langcore::global.CharactersRemaining')}}</small>
				</div>
				<div class="form-group">
					{!!Form::label('content', trans('Langcore::global.Content'),['class' =>'col-form-label']);!!}
					{!!CKediter::ckediter('content',($new['content'])?$new['content']:'')!!}
					@if ($errors->has('content'))
	                <small class="text-danger">{{ $errors->first('content') }}</small>
	                @endif
				</div>
				@seoCheckKeyword((empty($new))?new \Modules\News\Entities\News:$new)
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="card">
			<div class="card-body d-flex align-items-center p-3">
				<button class="btn btn-sm btn-primary" type="submit">
					<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
				</button>
				<div class="form-check checkbox ml-2">
					{!!Form::checkbox('active',1,($new['active']==1 || !$new)?true:false,['class'=>'form-check-input','id'=>'active'])!!}
					{!!Form::label('active', trans('Langcore::global.Active'),['class'=>'form-check-label']);!!}
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				{!!transmod('News::BelongsToCatalog')!!}
			</div>
			<div class="card-body p-0">
				@if(!empty($allcatalog))
					{!!$allcatalog!!}
				@endif
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				{!!trans('Langcore::global.Image')!!}
			</div>
			<div class="card-body p-2">
				<div class="d-block w-100 text-center border rounded p-2">
					<img src="{!!($new['image'])?$new['image']:themes('img/noimage.png')!!}" id="showimgpage" class="img-fluid">
				</div>
				{!! Form::hidden('image', ($new['image'])?$new['image']:'', ['id'=>'image', 'onchange'=>"uploadimg('#image','#showimgpage')"]) !!}
				{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmimgpage','data-input'=>'img_page','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=image")'])!!}
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				{!!trans('Langcore::global.Keywords')!!}
			</div>
			<div class="card-body p-3">
				{!! Form::text('keyword', ($new['keyword'])?$new['keyword']:'', ['class' => 'form-control','id'=>'keyword']) !!}
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
<script src="{{ asset('modules/js/news/adminnews.js.php') }}"></script>
<script src="{{ themes('admindefault:js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ themes('admindefault:js/jquery.caret.min.js') }}"></script>
<script src="{{ themes('admindefault:js/jquery.tag-editor.min.js') }}"></script>
<script type="text/javascript">
	$(function() {
        $('input[name="keyword"]').tagEditor({
        	placeholder: '{{trans('Langcore::global.Keywords')}}...'
        });
	});
	$(document).ready(function(){
	    $('.scrollbar-macosx').scrollbar();
	});
</script>
{!!CKediter::ckediterjs('content',300)!!}
<script type="text/javascript">
    $('.checktitleslug').bind('keyup',function(){
        title = $(this).val();
        slug = $('#slug').val();
        title_old = $('#title_old').val();
        slug_old = $('#slug_old').val();
        if (title) {
        	if (title != title_old || !title_old) {
        		checktitleslug(title,slug);
	        } else {
	        	$('button[type="submit"]').removeClass('btn-secondary').addClass('btn-primary');
	            $('.error-title').empty();
	            $('.error-slug').empty();
	        }
        } else {
            $('.error-title').empty();
            $('.error-slug').empty();
        }
    });
</script>
@endsection