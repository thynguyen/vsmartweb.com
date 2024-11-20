<div class="search mb-2 mb-lg-0">
  {!!Form::open(['method' => 'POST', 'route' => ['search.web.main'], 'enctype'=> 'multipart/form-data'])!!}
    <div class="search-form">
      <i class="fas fa-search"></i>
      {!! Form::text('query', old('query'), ['id'=>'query','placeholder'=>trans('Langcore::global.Search')])!!}
    </div>
    <button type="submit">
      <i class="fas fa-arrow-right"></i>
    </button>
  {!! Form::close() !!}
</div>