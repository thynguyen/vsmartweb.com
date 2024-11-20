@foreach($comments as $comment)
    <div class="display-comment @if($comment->parent_id != null) ml-5 @endif">
        <div class="d-flex justify-content-start w-100 mb-4">
            <div class="avatar-user mr-3">
                <img class="rounded-circle" width="{{($comment->parent_id == null)?60:50}}" src="@if($comment->user && !empty($comment->user->avatar)) {{ $comment->user->avatar }} @else {{ Avatar::create(($comment->user)?$comment->user->username:$comment->fullname)->setDimension(($comment->parent_id == null)?60:50)->setFontSize(($comment->parent_id == null)?22:16)->toBase64() }} @endif" alt="{{ ($comment->user)?$comment->user->username:$comment->fullname }}">
            </div>
            <div class="w-100 border rounded p-2 bg-white">
                <div class="d-flex justify-content-between">
                    <div class="info-user">
                        <strong>{{ ($comment->user)?$comment->user->username:$comment->fullname }}</strong>
                        @if($comment->vote)
                        <div class="rating">
                            <div class="starrate" style="width: {{($comment->vote*100)/5}}%"></div>
                            <div class="star"></div>
                        </div>
                        @endif
                        <br>
                        <small><i class="far fa-calendar-alt mr-1"></i>{{ $comment->created_at }}</small>
                    </div>
                    @if(Auth::check())
                        <button class="btn btn-link text-secondary align-self-start p-0" type="button" data-toggle="collapse" data-target="#{{$module.$item_id.'-'.$comment->id}}" aria-expanded="false" aria-controls="collapseExample"><small><i class="fas fa-pencil-alt mr-1"></i>{!!trans('Langcore::managercomment.ReplyComment')!!}</small></button>
                    @endif
                </div>
                <p>{{ $comment->comment }}</p>
                @if(Auth::check())
                <div class="collapse" id="{{$module.$item_id.'-'.$comment->id}}">
                    {!!Form::open(['method' => 'POST', 'route' => ['comments.store','module'=>$module], 'enctype'=> 'multipart/form-data'])!!}
                        <input type="hidden" name="item_id" value="{{ $item_id }}" />
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                        <div class="input-group">
                            <input type="text" name="comment" class="form-control" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{!!trans('Langcore::managercomment.ReplyComment')!!}</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                @endif
            </div>
        </div>
        @include('layouts.listcomments', ['comments' => $comment->replies])
    </div>
@endforeach