<div class="search-bar">
	<i class="fas fa-times fa-2x"></i>
	{!!Form::open(['method' => 'POST', 'route' => ['search.web.main'], 'enctype'=> 'multipart/form-data','class'=>'search-bar-fixed'])!!}
		{!! Form::text('query', old('query'), ['id'=>'query','placeholder'=>trans('Langcore::global.Search')])!!}
		<button type="submit"><i class="fa fa-search"></i></button>
	{!! Form::close() !!}
</div>