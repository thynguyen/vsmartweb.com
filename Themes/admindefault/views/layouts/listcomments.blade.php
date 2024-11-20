@foreach($comments as $comment)
    <div class="display-comment @if($comment->parent_id != null) ml-4 @endif">
        <div class="d-flex justify-content-start w-100 mb-4">
            <div class="avatar-user mr-3">
                <img class="rounded-circle" width="60" src="@if(!empty($comment->user->avatar)) {{ $comment->user->avatar }} @else {{ Avatar::create($comment->user->username)->setDimension(60)->setFontSize(22)->toBase64() }} @endif" alt="{{ $comment->user->username }}">
            </div>
            <div class="w-100 border rounded p-2">
                <div class="d-flex justify-content-between">
                    <div class="info-user">
                        <strong>{{ $comment->user->username }}</strong><br>
                        <small><i class="far fa-calendar-alt mr-1"></i>{{ $comment->created_at }}</small>
                    </div>
                    <button class="btn btn-brand btn-sm btn-html5 align-self-start" type="button" style="margin-bottom: 4px"onclick="redirectroute('{{ route('comment.adminedit',['id'=>$comment->id]) }}')">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </div>
                <p>{{ $comment->comment }}</p>
            </div>
        </div>
        @include('layouts.listcomments', ['comments' => $comment->replies])
    </div>
@endforeach