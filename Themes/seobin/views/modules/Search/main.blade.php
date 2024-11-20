@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Search','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_search_main')}}
@endsection
@section('header')
@endsection
@section('content')
{!!Form::open(['method' => 'POST', 'route' => ['search.web.main'], 'enctype'=> 'multipart/form-data'])!!}
<div class="card mb-3">
	<div class="card-body p-2">
		<div class="input-group">
			{!! Form::text('query', $searchterm, ['class' => 'form-control','id'=>'query','placeholder'=>trans('Langcore::global.Search')])!!}
			<div class="input-group-append">
				<button class="btn btn-primary" type="submit"><i class="fal fa-search"></i></button>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@if($searchterm)
<div class="card">
	<div class="card-body">
		@if(isset($searchResults))
			@if ($searchResults-> isEmpty())
				<h5>{!!transmod('search::NoResults',['key'=>$searchterm])!!}</h5>
			@else
				<h5>{!!transmod('search::TotalResult',['numquery'=>$searchResults->count(),'key'=>$searchterm])!!}</h5>
				<hr>
				@foreach($searchResults->groupByType() as $type => $modelSearchResults)
                <div class="card text-white bg-secondary mb-3">
                	<div class="card-body p-2">
	                	<h5 class="mb-0">{{ $type }}</h5>
	                </div>
                </div>
                <ul>
                @foreach($modelSearchResults as $searchResult)
                    <li class="mb-3">
                    	@if($searchResult->image)
                    	<div class="img-thumbnail float-left text-center mr-2" style="width: 120px;">
	                    	<img src="{!!ThemesFunc::GetThumb($searchResult->image,100)!!}" alt="{{ $searchResult->title }}" class="img-fluid">
	                    </div>
                    	@endif
                    	<h3 class="h5 mb-0"><a href="{{ $searchResult->url }}" title="{{ $searchResult->title }}" class="text-primary">{{ $searchResult->title }}</a></h3>
                    	<small>{{ $searchResult->url }}</small>
                    	<span class="text-secondary d-block">{{ $searchResult->description }}</span>
                    </li>
                @endforeach
                </ul>
                <hr>
                @endforeach
			@endif
		@endif
	</div>
</div>
@endif
@endsection
@section('footer')
@endsection