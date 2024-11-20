<div>
	<div class="d-flex justify-content-between mb-3">
		<div class="button">
			<button type="button" class="btn btn-primary btn-sm" onclick="addpage();">{!!transmod('pages::AddPage')!!}</button>
		</div>
		<div class="search rounded">
            {!! Form::text('searchpage', null, ['id'=>'searchpage','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchpage']) !!}
            <i class="fas fa-search"></i>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>{!!trans('Langcore::global.Title')!!}</th>
				<th width="180">{!!transmod('Pages::ContentImporter')!!}</th>
				<th width="150">Layout</th>
				<th>{!!transmod('Pages::PageGroups')!!}</th>
				<th width="180">{!!trans('Langcore::global.CreatDate')!!}</th>
				<th width="120">{!!trans('Langcore::global.Active')!!}</th>
				<th width="120">{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@if($pages)
			    @foreach($pages as $page)
			    <tr id="page{!!$page->id!!}">
			    	<td>{!!$page->title!!}</td>
			    	<td>{!!($page->pagetype == 1)?transmod('Pages::Editor'):transmod('Pages::PageBuilder')!!}</td>
			    	<td>{!!$page->layout!!}</td>
			    	<td>
			    		@if($page->group)
			    		<strong>{!!$page->group->title!!}</strong>
			    		@endif
			    	</td>
			    	<td>{!!$page->created_at!!}</td>
			    	<td>
			    		<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="active{!!$page->id!!}" onchange="activepage('{!!$page->id!!}');" {{($page->active)? 'checked':''}}>
							<label class="custom-control-label" for="active{!!$page->id!!}"></label>
						</div>
			    	</td>
			    	<td>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-dark" onclick="window.open('{!!route('pages.web.page',$page->slug->slug)!!}', '_blank')"><i class="fal fa-eye"></i></button>
							<button class="btn btn-sm btn-warning" type="button" onclick="addpage('{!!$page->id!!}')"><i class="fas fa-pencil-alt"></i></button>
							<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{!!route('pages.admin.editcontent',$page->id)!!}')"><i class="fas fa-cogs"></i></button>
							<button class="btn btn-sm btn-danger active"type="button" onclick="delpage('{!!$page->id!!}')"><i class="fas fa-trash-alt"></i></button>
						</div>
			    	</td>
			    </tr>
			    @endforeach
			@endif
		</tbody>
	</table>
	{!!$paginator!!}
</div>