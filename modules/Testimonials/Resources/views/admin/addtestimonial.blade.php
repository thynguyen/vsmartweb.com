<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['testimonials.admin.addtestimonial','id'=>($testimonial)?$testimonial->id:''], 'enctype'=> 'multipart/form-data'])!!}
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				{!!Form::label('avatar', trans('Langcore::global.Avatar'), ['class' => 'form-col-form-label w-100']);!!}
				<div class="d-block w-100 text-center border rounded p-2">
					<img src="{!!($testimonial['avatar'])?$testimonial['avatar']:themes('img/noimage.png')!!}" id="showimgpage" class="img-fluid">
				</div>
				{!! Form::hidden('avatar', $testimonial['avatar'], ['id'=>'avatar', 'onchange'=>"uploadimg('#avatar','#showimgpage')"]) !!}
				{!!Form::button('<i class="fas fa-avatar"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmimgpage','data-input'=>'img_page','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=avatar")'])!!}
			</div>
		</div>
		<div class="col-sm-8">
			<div class="form-group row">
				{!!Form::label('fullname', trans('Langcore::global.FullName'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('fullname', $testimonial['fullname'], ['class' => $errors->has('fullname') ? 'form-control is-invalid' : 'form-control','id'=>'fullname','required']) !!}
					@if ($errors->has('fullname'))
	                <div class="invalid-feedback">{{ $errors->first('fullname') }}</div>
	                @endif
	            </div>
			</div>
			<div class="form-group row">
				{!!Form::label('email', trans('Langcore::global.Email'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('email', $testimonial['email'], ['class' => 'form-control','id'=>'email']) !!}
	            </div>
			</div>
			<div class="form-group row">
				{!!Form::label('mobile', trans('Langcore::global.Mobile'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('mobile', $testimonial['mobile'], ['class' => 'form-control','id'=>'mobile']) !!}
	            </div>
			</div>
			<div class="form-group row">
				{!!Form::label('address', trans('Langcore::global.Address'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('address', $testimonial['address'], ['class' => 'form-control','id'=>'address']) !!}
	            </div>
			</div>
		</div>
	</div>
	<div class="form-group">
		{!!Form::label('testimonial', transmod('Testimonials::Opinion'),['class' =>'col-form-label']);!!}
		{!! Form::textarea('testimonial', $testimonial['testimonial'], ['class' => 'form-control','id'=>'testimonial','required','rows'=>5]) !!}
	</div>
	<button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
	{!! Form::close() !!}
</div>