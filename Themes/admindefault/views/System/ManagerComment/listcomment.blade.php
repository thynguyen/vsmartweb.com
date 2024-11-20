<div>
	<div class="d-flex align-items-center justify-content-between mb-3">
		<div>
			 {!!trans('Langcore::global.ShowTotalPage',['firstitem'=>$comments->firstItem(),'lastitem'=>$comments->lastItem(),'totalitem'=>$comments->total()])!!}
		</div>
		<div class="search rounded">
            {!! Form::text('searchcomment', null, ['id'=>'searchcomment','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchcomment']) !!}
            <i class="fas fa-search"></i>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white" id="listcommnet">
		<thead>
			<tr>
				<th>{{trans('Langcore::global.NumericalOrder')}}</th>
				<th>{!!trans('Langcore::managercomment.Comments')!!}</th>
	            <th>Vote</th>
				<th class="text-center">Module</th>
				<th class="text-center">{!!trans('Langcore::global.Account')!!}</th>
				<th>{!!trans('Langcore::global.CreatDate')!!}</th>
				<th>{!!trans('Langcore::global.Active')!!}</th>
				<th>{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($comments as $key => $comment)
			<tr>
				<td>{!!$key+1!!}</td>
				<td width="350">
					@if($comment->parent_id)
					<span class="badge badge-primary">Reply: {!!$comment->parentreply->comment!!}</span><br>
					@endif
					{!!$comment->comment!!}
					<hr class="m-1">
					<small>
						<i class="fas fa-file mr-1"></i>
						<a href="{!!$comment->item_link!!}" title="{!!$comment->item_title!!}" target="_black">{!!$comment->item_title!!}</a>
					</small>
				</td>
				<td class="text-center">
					<strong>{!!($comment->vote)?$comment->vote:0!!}</strong>
					<i class="fas fa-star text-warning"></i>
				</td>
				<td class="text-center">
					{!!$comment->module!!}
				</td>
				<td class="text-center">
					@if($comment->user)
					{!!$comment->user->full_name!!}
					@else
					{!!$comment->fullname!!}<br>{!!$comment->email!!}
					@endif
				</td>
				<td>{!!$comment->created_at->diffForhumans()!!}</td>
				<td class="text-center">
		    		<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="active{!!$comment->id!!}"  onchange="actiontable('{!!route('comment.adminactive',$comment->id)!!}')" {{($comment->active)? 'checked':''}}>
						<label class="custom-control-label" for="active{!!$comment->id!!}"></label>
					</div>
				</td>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-info" onclick="window.open('{!!$comment->item_link!!}')">
							<i class="fal fa-eye"></i>
						</button>
						<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{!! route('comment.adminedit',['id'=>$comment->id])!!}')"><i class="fas fa-edit"></i></button>
						<button class="btn btn-sm btn-danger active" type="button" onclick="deltable('{!!route('comment.admindel',['id'=>$comment->id])!!}','{!!trans('Langcore::global.warning_delfile')!!}')"><i class="fas fa-trash-alt"></i></button>
	 				</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="d-flex align-items-center justify-content-between mt-3">
		<div>
			 {!!trans('Langcore::global.ShowTotalPage',['firstitem'=>$comments->firstItem(),'lastitem'=>$comments->lastItem(),'totalitem'=>$comments->total()])!!}
		</div>
		<div>
            {!!$paginator!!}
		</div>
	</div>
</div>