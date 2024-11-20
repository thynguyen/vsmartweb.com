<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['servicepack.admin.addservicepack','id'=>($servicepack)?$servicepack->id:''], 'enctype'=> 'multipart/form-data'])!!}
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group row">
				{!!Form::label('title', trans('Langcore::global.Title'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::text('title', $servicepack['title'], ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control','id'=>'title','required','onkeyup'=>'ChangeToSlug("title","slug","showslug")']) !!}
					@if ($errors->has('title'))
		            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
		            @endif
		        </div>
			</div>
			<div class="form-group row">
				{!!Form::label('slug', 'URL Slug',['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					<div class="d-flex align-items-center">
						{{url('/')}}/{{AdminFunc::GetPrefixMod('ServicePack')}}/{!! Form::hidden('slug', ($servicepack['slug'])?$servicepack['slug']['slug']:'', ['class' => 'form-control w-50 d-inline-block','id'=>'slug','onkeyup'=>'ChangeInputSlug("showslug")']) !!}
						<span id="showslug">{{$servicepack['slug']['slug']}}</span>.html <button id="showinput" onclick="BTshowIPSlug('slug','showslug','showinput')" type="button" class="ml-2 btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
					</div>
		            <small class="error-slug"></small>
		        </div>
			</div>
			<div class="form-group row">
				{!!Form::label('description', trans('Langcore::global.Description'),['class' =>'col-sm-2 col-form-label']);!!}
				<div class="col-sm-10">
					{!! Form::textarea('description', $servicepack['description'], ['class' => 'form-control','id'=>'description','rows'=>3,'placeholder'=>trans('Langcore::global.Description')]) !!}
		        </div>
			</div>
			<div class="form-group row">
				<div class="col-sm-10 offset-md-2">
					<div class="custom-control custom-switch">
						{!!Form::checkbox('popular',1,($servicepack['popular']==1)?true:false,['class'=>'custom-control-input', 'id'=>'popular'])!!}
						<label class="custom-control-label" for="popular">{{transmod('ServicePack::Popular')}}</label>
					</div>
		        </div>
			</div>
			<div class="form-group row">
				<div class="col-sm-10 offset-md-2">
					<div class="custom-control custom-switch">
						{!!Form::checkbox('contact',1,($servicepack['contact']==1)?true:false,['class'=>'custom-control-input', 'id'=>'contact'])!!}
						<label class="custom-control-label" for="contact">{{transmod('ServicePack::Contact')}}</label>
					</div>
		        </div>
			</div>
			<div id="priceservice" style="display: {{($servicepack['contact']==1)?'none':'block'}};">
				<div class="form-group row">
					{!!Form::label('price', transmod('ServicePack::Price'),['class' =>'col-sm-2 col-form-label']);!!}
					<div class="col-sm-10">
						{!! Form::text('price', $servicepack['price'], ['class' => $errors->has('price') ? 'form-control is-invalid' : 'form-control','id'=>'price']) !!}
						@if ($errors->has('price'))
			            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
			            @endif
			        </div>
				</div>
				<div class="form-group row">
					{!!Form::label('price_sale', transmod('ServicePack::Discount'),['class' =>'col-sm-2 col-form-label']);!!}
					<div class="col-sm-10">
						{!! Form::text('price_sale', $servicepack['price_sale'], ['class' => 'form-control','id'=>'price_sale']) !!}
			        </div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<button type="button" class="btn btn-block btn-primary mb-3" onclick="plusoption();">+</button>
			<div id="listoptions">
				@foreach($listoption as $i=>$option)
				<div class="listoption{{$i}}">
					<div class="form-group row no-gutters">
						{!! Form::text('listoption['.$i.']', $option, ['class' => 'form-control col-sm-10','id'=>'listoption'.$i]) !!}
						<div class="col-sm-2 text-center">
							<button type="button" class="btn btn-danger" onclick="deleteoption('listoption{{$i}}')"><i class="fal fa-trash-alt"></i></button>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
	{!! Form::close() !!}
	<script type="text/javascript">
		var numrow = '{{$numrow}}';
	</script>
</div>