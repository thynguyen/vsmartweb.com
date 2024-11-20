@if(Route::current()->getName() != 'indexhome')
@if (count($breadcrumbs))
<div id="banner-area" class="banner-area" {{ !empty($breadcrumbs[count($breadcrumbs)-1]->background )? 'style=background-image:url(\''.$breadcrumbs[count($breadcrumbs)-1]->background.'\');' : 'style=background-image:url(\''.themes('images/banner/banner5.jpg').'\');'}}>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="banner-heading">
          <h1 class="banner-title">{{ $breadcrumbs[count($breadcrumbs)-1]->title }}</h1>
          <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
            <li><a href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</a></li>
            @else
            <li><span>{{ $breadcrumb->title }}</span></li>
            @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endif