@extends('layouts.master')
@section('metatitle',trans('Langcore::managercomment.ManagerCommnet'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_editcomment')}}
@endsection
@section('header')
@endsection
@section('content')
{!!Form::open(['method' => 'POST', 'route' => ['comment.adminedit','id'=>$comment->id], 'enctype'=> 'multipart/form-data'])!!}
<button class="btn btn-brand btn-sm btn-youtube" type="button" style="margin-bottom: 4px" onclick="backpage()">
    <i class="fas fa-long-arrow-alt-left"></i>
    <span>{{trans('Langcore::global.Back')}}</span>
</button>
<button class="btn btn-brand btn-sm btn-twitter" style="margin-bottom: 4px" type="submit">
    <i class="fas fa-dot-circle"></i><span>{{trans('Langcore::global.Save')}}</span>
</button>
<div class="card">
    <div class="card-body">
        <h4 class="mr-2 mb-0">{!!($comment->user)?$comment->user->username:$comment->fullname.'<br><small>'.$comment->email.'</small>'!!}</h4>
        <small class="d-block mb-3">
            Module: {!!$comment->module!!} | {!!trans('Langcore::global.Posts')!!}: <strong>{{$comment->title_item}}</strong><br>{!!trans('Langcore::global.CreatDate')!!}: {!!$comment->created_at!!}
        </small>
        {!! Form::textarea('comment', $comment->comment, ['class' =>$errors->has('comment') ? 'form-control is-invalid' : 'form-control','id'=>'question','rows'=>4]) !!}
        @if ($errors->has('comment'))
        <div class="invalid-feedback">{{ $errors->first('comment') }}</div>
        @endif

        <div class="form-check checkbox mb-2">
            {!!Form::checkbox('active',1,($comment->active==1)?true:false,['class'=>'form-check-input','id'=>'active'])!!}
            {!!Form::label('active', trans('Langcore::global.Active'),['class'=>'form-check-label']);!!}
        </div>
    </div>
</div>
@if(count($comment->adminreplies)>0)
<div class="card">
    <div class="card-body">
        @include('layouts.listcomments', ['comments' => $comment->adminreplies, 'item_id' => $comment->id,'module'=>$comment->module])
    </div>
</div>
@endif
{!! Form::close() !!}
@endsection
@section('footer')
@endsection