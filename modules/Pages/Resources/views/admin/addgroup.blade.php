<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['pages.admin.addgroup','id'=>$group['id']], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group row">
			{!!Form::label('title', trans('Langcore::global.Title'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('title', $group['title'], ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control','id'=>'title','onkeyup'=>'ChangeToSlug("title","slug","showslug")']) !!}
				@if ($errors->has('title'))
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                @endif
                <small class="error-title"></small>
            </div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2">
				{!!Form::label('slug', 'URL Slug',['class' =>'col-form-label']);!!} <button id="showinput" onclick="BTshowIPSlug('slug','showslug','showinput')" type="button" class="ml-2 btn btn-link btn-sm"><i class="fas fa-pencil-alt"></i></button>
			</div>
			<div class="col-sm-10">
				<div class="d-flex align-items-center h-100">
					{{url('/').'/pages/group/'}}
					{!! Form::hidden('slug', ($group['slug'])?$group['slug']['slug']:'', ['class' => 'form-control w-50 d-inline-block','id'=>'slug','onkeyup'=>'ChangeInputSlug("showslug")']) !!}
					<span id="showslug">{!!($group)?$group->slug->slug:''!!}</span>.html
				</div>
			    <small class="error-slug"></small>
			</div>
		</div>
		<div class="form-group position-relative">
			{!!Form::label('description', trans('Langcore::global.Description'),['class' =>'col-form-label']);!!}
			{!! Form::textarea('description', ($group['description'])?$group['description']:'', ['class' => 'form-control','id'=>'description','rows'=>4,'onKeyDown'=>'return text_length("description","desclength" ,350)','onKeyUp'=>'return text_length("description","desclength" ,350)']) !!}
			<small style="position: absolute;top: 10px;right: 5px;"><span id="desclength">{{($group['description'])?350-strlen($group['description']):350}}</span> {{trans('Langcore::global.CharactersRemaining')}}</small>
		</div>
		<div class="form-group">
			{!!Form::label('keyword', trans('Langcore::global.Keywords'),['class' =>'col-form-label']);!!}
			{!! Form::text('keyword', ($group['keyword'])?$group['keyword']:'', ['class' => 'form-control','id'=>'keyword']) !!}
		</div>
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	{!! Form::close() !!}
</div>