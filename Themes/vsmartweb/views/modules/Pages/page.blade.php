@extends($getlayout)
@section('metatitle',$page->title)
@section('breadcrumbs')
{{Breadcrumbs::render('module_pages_page',$page)}}
@endsection
@section('header')
@endsection
@section('content')
<div class="post-content post-single">
   <div class="post-body">
      <div class="entry-header">
         <h1 class="entry-title">
            {!!$page->title!!}
         </h1>
      </div>
      <div class="entry-content">
         {!!json_decode($page->content->content)!!}
      </div>
   </div>
</div>
@endsection
@section('footer')
@endsection