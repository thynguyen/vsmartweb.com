@extends('pages::admin.master')
@section('metatitle',AdminFunc::ReturnModule('Pages','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_pages_main')}}
@endsection
@section('header')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/pages/chooseinterface.css.php') }}">
@livewireStyles
@endsection
@section('content')
@livewire('chooseinterface',['id'=>$id,'category'=>$category])
@endsection
@section('footer')
<script src="{{ asset('modules/js/pages/adminpages.js.php') }}"></script>
<script src="{{ asset('modules/js/pages/chooseinterface.js.php') }}"></script>
@livewireScripts
<!-- <script type="text/javascript">
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            window.livewire.emit('load-more');
        }
    };
</script> -->
@endsection