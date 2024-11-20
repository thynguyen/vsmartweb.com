<section id="main-container" class="padding-b-100 padding-t-60">
	<div class="container">
		<h1 class="fs-3 mb-5">{{$interface->title}}</h1>
	</div>
	<div class="border-bottom mb-4">
		<div class="container">
			<div class="nav nav-tabs border-bottom-0" id="InterfaceTabs" role="tablist">
				<a class="nav-link active" id="detailinterface-tab" data-bs-toggle="tab" href="#detailinterface" role="tab" aria-controls="detailinterface" aria-selected="true">{{trans('Langcore::global.Detail')}}</a>
				<a class="nav-link" id="commentinterface-tab" data-bs-toggle="tab" href="#commentinterface" role="tab" aria-controls="commentinterface" aria-selected="false">{{trans('Langcore::managercomment.Comments')}}</a>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="detailinterface" role="tabpanel" aria-labelledby="detailinterface-tab">
						<div class="card mb-5">
							<img src="{{$interface->image}}" class="card-img-top" alt="{{$interface->title}}">
							<div class="card-body">
								<div class="d-flex justify-content-center">
									<div id="btnsentiment" class="btn-group align-self-start">
										@if(!$interface->authsentiment || $interface->authsentiment && $interface->authsentiment->userid != Auth::user()->id)
										<button onclick="sentiment('like','{{$interface->id}}')" type="button" class="btn btn-sm btn-success"><i class="fal fa-thumbs-up"></i></button>
										<button onclick="sentiment('dislike','{{$interface->id}}')" type="button" class="btn btn-sm btn-danger"><i class="fal fa-thumbs-down"></i></button>
										@else
										<button onclick="sentiment('undo','{{$interface->id}}')" type="button" class="btn btn-sm btn-secondary">
											@if($interface->authsentiment->sentiment == 'like')
											<i class="fal fa-thumbs-up"></i>
											@else
											<i class="fal fa-thumbs-down"></i>
											@endif
										</button>
										@endif
									</div>
									<div class="addthis_inline_share_toolbox"></div>
								</div>
							</div>
						</div>
						{!!$interface->content!!}
					</div>
					<div class="tab-pane fade" id="commentinterface" role="tabpanel" aria-labelledby="commentinterface-tab">
						{!!Comments::GetViewComments('InterfacePackage',$interface)!!}
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card mb-3">
					<div class="card-body">
						<div class="d-grid gap-2">
							<button type="button" class="btn btn-primary">{{transmod('InterfacePackage::Apply')}}</button>
						</div>
					</div>
				</div>
				<div class="card mb-3">
					<div class="card-body">
						<div class="card-title mb-4">
							<h4>Thông tin</h4>
						</div>
						<dl class="row">
							<dt class="col-sm-4">{{transmod('InterfacePackage::Released')}}</dt>
							<dd class="col-sm-8">{{format_time($interface->created_at,'j/m/Y')}}</dd>
							<dt class="col-sm-4">{{transmod('InterfacePackage::Category')}}</dt>
							<dd class="col-sm-8">{{$interface->cat->title}}</dd>
							@if($interface->keywords)
							<dt class="col-sm-4">Tags</dt>
							<dd class="col-sm-8">
								@foreach($interface->keywords as $key => $keyword)
								<a href="{!!route('search.web.tag',['keyword'=>$keyword])!!}" title="{!!$keyword!!}" rel="tag">{!!$keyword!!}</a>{!!($key == count($interface->keywords)-1)?'':','!!}
								@endforeach
							</dd>
							@endif
						</dl>
					</div>
				</div>
				<ul class="list-group list-group-horizontal mb-3">
					<li class="bg-light w-50 list-group-item">
						<i class="fal fa-comments-alt fa-lg fa-fw mr-2"></i><span class="fw-bold">{{$interface->comments->count()}}</span> {{trans('Langcore::managercomment.Comments')}}
					</li>
					<li class="bg-light w-50 list-group-item">
						<i class="fal fa-star fa-lg fa-fw mr-2"></i><span class="fw-bold">{{($interface->rate['totalrate'])?$interface->rate['totalrate']:0}}</span> {{transmod('InterfacePackage::Point')}} @if($interface->rate['percentrate'])({{$interface->rate['percentrate']}}%)@endif
					</li>
				</ul>
				<ul class="list-group list-group-horizontal mb-3" id="sentiment">
					<li class="bg-light w-50 list-group-item">
						<span class="d-block">
							<i class="fal fa-thumbs-up fa-lg fa-fw mr-2"></i>
							<span class="fw-bold">{{$interface->sentimentlike->count()}}</span>
						</span>
					</li>
					<li class="bg-light w-50 list-group-item">
						<span class="d-block">
							<i class="fal fa-thumbs-down fa-lg fa-fw mr-2"></i>
							<span class="fw-bold">{{$interface->sentimentdislike->count()}}</span>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>