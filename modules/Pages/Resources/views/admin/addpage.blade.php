{!!Form::open(['method' => 'POST', 'route' => ['pages.admin.addpage','id'=>$page['id']], 'enctype'=> 'multipart/form-data'])!!}
@if($page)
{!! Form::hidden('title_old', $page['title'], ['id'=>'title_old']) !!}
{!! Form::hidden('slug_old', $page['slug'], ['id'=>'slug_old']) !!}
@endif
<div class="modal-body">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group row">
				{!!Form::label('title', trans('Langcore::global.Title'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('title', ($page['title'])?$page['title']:'', ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control','id'=>'title','onkeyup'=>'ChangeToSlug("title","slug","showslug")']) !!}
		            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
		            <small class="error-title"></small>
		        </div>
			</div>
			<div class="form-group row">
				{!!Form::label('slug', 'URL Slug',['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					<div class="d-flex align-items-center">
						{{$http_host.'/'}}
						{!! Form::hidden('slug', ($page['slug'])?$page['slug']:'', ['class' => 'form-control w-50 d-inline-block','id'=>'slug','onkeyup'=>'ChangeInputSlug("showslug")']) !!}
						<span id="showslug">{{$page['slug']}}</span>.html <button id="showinput" onclick="BTshowIPSlug('slug','showslug','showinput')" type="button" class="ml-2 btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
					</div>
		            <small class="error-slug"></small>
		        </div>
			</div>
			<div class="form-group position-relative">
				{!!Form::label('description', trans('Langcore::global.Description'),['class' =>'col-form-label']);!!}
				{!! Form::textarea('description', ($page['description'])?$page['description']:'', ['class' => 'form-control','id'=>'description','rows'=>4,'onKeyDown'=>'return text_length("description","desclength" ,350)','onKeyUp'=>'return text_length("description","desclength" ,350)']) !!}
				<small style="position: absolute;top: 10px;right: 5px;"><span id="desclength">{{($page['description'])?350-strlen($page['description']):350}}</span> {{trans('Langcore::global.CharactersRemaining')}}</small>
			</div>
			<div class="form-group">
				{!!Form::label('keyword', trans('Langcore::global.Keywords'),['class' =>'col-form-label']);!!}
					{!! Form::text('keyword', ($page['keyword'])?$page['keyword']:'', ['class' => 'form-control','id'=>'keyword']) !!}
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				{!!Form::label('groupid', transmod('Pages::PageGroups'),['class' =>'col-form-label']);!!}
				{!!Form::select('groupid', $groups, $page['groupid'], ['class' => 'custom-select','id'=>'groupid'])!!}
			</div>
			<div class="form-group">
				{!!Form::label('pagetype', transmod('Pages::ContentImporter'),['class' =>'col-form-label']);!!}
				{!!Form::select('pagetype', $pagetype, $page['pagetype'], ['class' => 'custom-select','id'=>'pagetype','onchange'=>'changepagatype();'])!!}
			</div>
			<div class="form-group" id="showlayout" style="{!!($page['pagetype']==1 || !$page)?'':'display:none'!!}">
				{!!Form::label('layout', 'Layout',['class' =>'col-form-label']);!!}
				{!!Form::select('layout', $listlayout, ($page['layout'])?$page['layout']:'', ['class' => 'custom-select','id'=>'layout','onchange'=>'getdemothumblayout();'])!!}
				<div id="btnshowthumb"></div>
			</div>
			<div class="form-group">
				{!!Form::label('image', trans('Langcore::global.Image'), ['class' => 'form-col-form-label w-100']);!!}
				<div class="d-block w-100 text-center border rounded p-2">
					<img src="{!!($page['image'])?$page['image']:themes('img/noimage.png')!!}" id="showimgpage" class="img-fluid">
				</div>
				{!! Form::hidden('image', ($page['image'])?$page['image']:'', ['id'=>'image', 'onchange'=>"uploadimg('#image','#showimgpage')"]) !!}
				{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmimgpage','data-input'=>'img_page','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=image")'])!!}
			</div>
			<div class="form-check checkbox mb-2">
				{!!Form::checkbox('active',1,($page['active']==1 || !$page)?true:false,['class'=>'form-check-input', 'id'=>'active'])!!}
				{!!Form::label('active', trans('Langcore::global.Active'),['class'=>'form-check-label','for'=>'active']);!!}
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="submit">{{($page)?trans('Langcore::global.Save'):transmod('Pages::Next')}}
	</button>
</div>
{!! Form::close() !!}