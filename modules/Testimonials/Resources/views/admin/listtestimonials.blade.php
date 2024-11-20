<div>
	<div class="card">
		<div class="card-body p-2">
			<div class="d-flex align-items-center justify-content-between">
				<div class="button">
					<button type="button" class="btn btn-sm btn-primary" onclick="addtestimonial();">{!!transmod('Testimonials::AddTestimonial')!!}</button>
				</div>
				<div class="search rounded">
		            {!! Form::text('searchtestimonials', null, ['id'=>'searchtestimonials','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchtestimonials']) !!}
		            <i class="fas fa-search"></i>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>{!!transmod('Testimonials::Opinion')!!}</th>
				<th>{!!transmod('Testimonials::Info')!!}</th>
				<th>{!!trans('Langcore::global.Active')!!}</th>
				<th>{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($testimonials as $testimonial)
			<tr id="testimonial{!!$testimonial->id!!}">
				<td width="400">{!!$testimonial->testimonial!!}</td>
				<td>
					<strong>{!!trans('Langcore::global.FullName')!!}:</strong> {!!$testimonial->fullname!!}<br>
					<strong>{!!trans('Langcore::global.Email')!!}: </strong> {!!$testimonial->email!!}<br>
					<strong>{!!trans('Langcore::global.Mobile')!!}: </strong> {!!$testimonial->mobile!!}<br>
					<strong>{!!trans('Langcore::global.Address')!!}: </strong> {!!$testimonial->address!!}
				</td>
				<td>
		    		<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="active{!!$testimonial->id!!}" onchange="activetestimonial('{!!$testimonial->id!!}');" {{($testimonial->active)? 'checked':''}}>
						<label class="custom-control-label" for="active{!!$testimonial->id!!}"></label>
					</div>
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="addtestimonial('{!!$testimonial->id!!}');"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" class="btn btn-sm btn-danger" onclick="deltestimonial('{!!$testimonial->id!!}');"><i class="fas fa-trash-alt"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!!$paginator!!}
</div>