<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['news.admin.addcategory','id'=>$category['id']], 'enctype'=> 'multipart/form-data'])!!}
		{!!Form::hidden('parentold', $category['parentid'])!!}
		<div class="form-group row">
			{!!Form::label('title', trans('Langcore::global.Title'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('title', ($category['title'])?$category['title']:'', ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control','id'=>'title','onkeyup'=>'ChangeToSlug("title","slug","showslug")']) !!}
				@if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                @endif
            </div>
		</div>
		<div class="form-group">
			{!!Form::label('slug', 'URL Slug',['class' =>'col-form-label']);!!} <button id="showinput" onclick="BTshowIPSlug('slug','showslug','showinput')" type="button" class="ml-2 btn btn-link btn-sm"><i class="fas fa-pencil-alt"></i></button>
			<div class="d-flex align-items-center">
				{{url('/').'/'.AdminFunc::GetPrefixMod('News').'/cat/'}}
				{!! Form::hidden('slug', ($category['slug'])?$category['slug']:'', ['class' => 'form-control w-50 d-inline-block','id'=>'slug','onkeyup'=>'ChangeInputSlug("showslug")']) !!}
				<span id="showslug">{!!($category)?$category->slug->slug:''!!}</span>.html
			</div>
		</div>
		<div class="form-group">
			{!!Form::label('parentid', transmod('News::BelongsToCatalog'),['class' =>'col-form-label']);!!}
			@if(!empty($allcatalog))
				{!!$allcatalog!!}
			@endif
		</div>
		<div class="form-group position-relative">
			{!!Form::label('description', trans('Langcore::global.Description'),['class' =>'col-form-label']);!!}
			{!! Form::textarea('description', ($category['description'])?$category['description']:'', ['class' => 'form-control','id'=>'description','rows'=>4,'onKeyDown'=>'return text_length("description","desclength" ,350)','onKeyUp'=>'return text_length("description","desclength" ,350)']) !!}
			<small style="position: absolute;top: 10px;right: 5px;"><span id="desclength">{{($category['description'])?350-strlen($category['description']):350}}</span> {{trans('Langcore::global.CharactersRemaining')}}</small>
		</div>
		<div class="form-group">
			{!!Form::label('keyword', trans('Langcore::global.Keywords'),['class' =>'col-form-label']);!!}
			{!! Form::text('keyword', ($category['keyword'])?$category['keyword']:'', ['class' => 'form-control','id'=>'keyword']) !!}
		</div>
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	{!! Form::close() !!}
</div>