<div class="modal-body">
	<h5 class="text-center">{{$user->username}}</h5>
	<hr>
	<dl class="row">
		<dt class="col-sm-3">
			{{trans('Langcore::global.FullName')}}
		</dt>
		<dd class="col-sm-9">{{$user->full_name}}</dd>
		<dt class="col-sm-3">
			{{trans('Langcore::global.Email')}}
		</dt>
		<dd class="col-sm-9"><a href="mailto:{{$user->email}}" title="{{$user->email}}">{{$user->email}}</a></dd>
		<dt class="col-sm-3">
			{{trans('Langcore::global.Mobile')}}
		</dt>
		<dd class="col-sm-9"><a href="tel:{{$user->mobile}}" title="{{$user->mobile}}">{{$user->mobile}}</a></dd>
		<dt class="col-sm-3">
			{{trans('Langcore::global.Address')}}
		</dt>
		<dd class="col-sm-9">{{$user->address}}</dd>
	</dl>
</div>