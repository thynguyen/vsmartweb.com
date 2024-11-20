<div class="modal-body">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
			    {!! Form::text('title', $slider['title'], ['class' => 'form-control form-control-sm','id'=>'title','placeholder'=>trans('Langcore::global.Title')]) !!}
			</div>
			<div class="form-group">
			    {!! Form::textarea('description', $slider['description'], ['class' => 'form-control form-control-sm','id'=>'description','rows'=>4,'placeholder'=>trans('Langcore::global.Description')]) !!}
			</div>
			<div class="form-group">
			    {!! Form::text('link', $slider['link'], ['class' => 'form-control form-control-sm','id'=>'link','placeholder'=>transmod('sliders::Link')]) !!}
			</div>
			<hr>
			{!!Form::label('null', 'Style', ['class' => 'form-col-form-label w-100']);!!}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					    {!! Form::text('custom_id', $slider['custom_id'], ['class' => 'form-control form-control-sm','id'=>'custom_id','placeholder'=>transmod('sliders::CustomID')]) !!}
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    {!! Form::text('custom_class', $slider['custom_class'], ['class' => 'form-control form-control-sm','id'=>'custom_class','placeholder'=>transmod('sliders::CustomClass')]) !!}
					</div>
				</div>
			</div>
			@if(count($templates)>0)
			<div class="form-group">
				{!!Form::label('template', 'Template', ['class' => 'form-col-form-label w-100']);!!}
			    {!! Form::select('template', $templates, ($slider)?$slider->template->template:'', ['class' => 'form-control','id'=>'template']) !!}
			</div>
			@endif
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				{!!Form::label('image', trans('Langcore::global.Image'), ['class' => 'form-col-form-label w-100']);!!}
				<div class="d-block w-100 text-center border rounded p-2">
					<img src="{!!($slider['image'])?$slider['image']:themes('img/noimage.png')!!}" id="showimgpage" class="img-fluid">
				</div>
				{!! Form::hidden('image', ($slider['image'])?$slider['image']:'', ['id'=>'image', 'onchange'=>"uploadimg('#image','#showimgpage')"]) !!}
				{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmimgpage','data-input'=>'img_page','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&fldr=sliders&type=0&popup=1&field_id=image")'])!!}
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="button" onclick="submitaddslider({!!$groupid!!},{!!$id!!})">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
</div>