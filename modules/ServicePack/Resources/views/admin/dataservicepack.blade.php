<div>
	<div class="card">
		<div class="card-body p-2">
			<div class="d-flex align-items-center justify-content-between">
				<div class="button">
					<button type="button" class="btn btn-sm btn-primary" onclick="addservicepack();">{!!transmod('ServicePack::AddServicePack')!!}</button>
				</div>
				<div class="search rounded">
		            {!! Form::text('searchservicepack', null, ['id'=>'searchservicepack','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchservicepack']) !!}
		            <i class="fas fa-search"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="listitem">
		@foreach($servicepacks as $servicepack)
		<div class="col-sm-{{($servicepacks->total()<5)?round(12/$servicepacks->total()):'3'}}" id="servicepack{!!$servicepack->id!!}">
			<div class="card">
				<div class="card-header">
					<strong>{{$servicepack->title}}</strong>
					<div class="card-header-actions">
						<button type="button" class="card-header-action btn btn-link" onclick="addservicepack('{{$servicepack->id}}');"><i class="fal fa-pencil"></i></button>
						<button type="button" class="card-header-action btn btn-link" onclick="delservicepack('{{$servicepack->id}}');"><i class="fal fa-trash-alt"></i></button>
						<button type="button" class="card-header-action btn btn-link {{($servicepack->active == 1)?'text-success':'text-secondary'}}" onclick="activeprice(this,'{{$servicepack->id}}');"><i class="fas fa-check-circle"></i></button>
						<button class="btn btn-sm btn-secondary" type="button" data-toggle="collapse" data-target="#weightservicepack{!!$servicepack->id!!}" aria-expanded="false" aria-controls="weightservicepack{!!$servicepack->id!!}">
						<strong>{!!$servicepack->weight!!}</strong>
						</button>
						<div class="collapse position-absolute" id="weightservicepack{!!$servicepack->id!!}">
							<div class="card card-body">
			                    <select class="form-control mb-2" id="idweight_{!!$servicepack->id!!}" onchange="changepriceweight('{!!$servicepack->id!!}','idweight_{!!$servicepack->id!!}')">
			                        @for($i=1;$i<=$servicepacks->total();$i++)
			                        <option value="{!!$i!!}" {{($i==$servicepack['weight'])?'selected="selected"':''}}>{!!$i!!}</option>
			                        @endfor
			                    </select>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<small class="d-block">{{$servicepack->description}}</small>
					@if($servicepack->contact == 1)
					<span class="font-weight-bold">{{transmod('ServicePack::Contact')}}</span>
					@else
					@if($servicepack->price_sale > 0)
					<span class="mr-1 font-weight-bold">{!!$servicepack->price_sale!!} đ</span><span><del>{!!$servicepack->price!!} đ</del></span>
					@else
					<span class="font-weight-bold">{!!$servicepack->price!!} đ</span>
					@endif
					@endif
					@if($servicepack->listoption!='null')
					<ul class="list-group list-group-flush mt-3">
						@foreach(json_decode($servicepack->listoption,true) as $key => $option)
						<li class="list-group-item px-0 py-2">
							{{$option}}
						</li>
						@endforeach
					</ul>
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
	{!!$paginator!!}
</div>