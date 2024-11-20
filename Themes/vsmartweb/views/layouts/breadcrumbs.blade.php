@if(Route::current()->getName() != 'indexhome')
@if (count($breadcrumbs))
<section id="breadcrumb" class="bg-primary padding-t-120 padding-b-60">
   <div class="container">
      <div class="vsw-breadcrumb vsw-breadcrumb-center">
         <h3 class="breadcrumb-title">{{ $breadcrumbs[count($breadcrumbs)-1]->title }}</h3>
         <ul class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
            <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}" class="text-decoration-none">{{ $breadcrumb->title }}</a></li>
            @else
            <li class="breadcrumb-item active"><span>{{ $breadcrumb->title }}</span></li>
            @endif
            @endforeach
         </ul>
      </div>
   </div>
</section>
@endif
@endif