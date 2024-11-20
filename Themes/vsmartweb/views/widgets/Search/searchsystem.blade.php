<div class="collapse w-100" id="searchbox">
	<div class="bg-white rounded-0 shadow-sm py-5">
	   {!!Form::open(['method' => 'POST', 'route' => ['search.web.main'], 'enctype'=> 'multipart/form-data','class'=>'d-flex pb-2 px-2 m-auto border-bottom','style'=>'max-width: 800px;'])!!}
	      {!! Form::text('query', old('query'), ['id'=>'query','class'=>'border-0 w-100','placeholder'=>trans('Langcore::global.Search')])!!}
	      <button type="submit" class="btn btn-sm btn-link text-secondary"><i class="fal fa-search fa-lg"></i></button>
	      <button type="button" class="btn btn-sm btn-link text-secondary" data-toggle="collapse" data-target="#searchbox" aria-expanded="false" aria-controls="searchbox"><i class="fal fa-times fa-lg"></i></button>
	   {!! Form::close() !!}
	</div>
</div>
<button type="button" class="btn btn-sm btn-link text-white" data-toggle="collapse" data-target="#searchbox" aria-expanded="false" aria-controls="searchbox"><i class="fal fa-search fa-lg"></i></button>