<div>
	<div class="card">
		<div class="card-body p-2">
			<div class="d-flex align-items-center justify-content-between">
				<div class="button">
					@if($category[0] && $category[0]->catparent)
					<button type="button" class="btn btn-sm btn-success" onclick="redirectroute('{!!route('news.admin.category',['id'=>$category[0]->catparent->parentid])!!}')">
						<i class="fal fa-arrow-to-left"></i> {!!trans('Langcore::global.Back')!!}
					</button>
					@endif
					<button type="button" class="btn btn-sm btn-primary" onclick="addcategory();">
						{!!transmod('News::AddCatalogNews')!!}
					</button>
				</div>
				<div class="search rounded">
		            {!! Form::text('searchcat', null, ['id'=>'searchcat','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchcat']) !!}
		            <i class="fas fa-search"></i>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th width="100" align="center">{{trans('Langcore::global.NumericalOrder')}}</th>
				<th>{!!trans('Langcore::global.Title')!!}</th>
				<th width="180">{!!trans('Langcore::global.CreatDate')!!}</th>
				<th width="100">{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@if($category)
			    @foreach($category as $cat)
			    <tr id="cat{!!$cat->id!!}">
			    	<td>
	                    <select class="form-control" id="idweight_{{$cat->id}}" onchange="changeweightcategory('{!!$cat->id!!}','{!!$cat->parentid!!}','idweight_{!!$cat->id!!}','tbody')">
	                        @for($i=1;$i<=$num;$i++)
	                        <option value="{!!$i!!}" {{($i==$cat->weight)?'selected="selected"':''}}>{!!$i!!}</option>
	                        @endfor
	                    </select>
			    	</td>
			    	<td>
			    		@if(count($cat->subcat)>0)
			    		<a href="{!!route('news.admin.category',['id'=>$cat->id])!!}" title="{!!$cat->title!!}">{!!$cat->title!!}</a>
			    		@else
			    		{!!$cat->title!!}
			    		@endif
			    		@if(count($cat->subcat)>0)
			    		<span class="badge badge-primary" data-toggle="collapse" data-target="#subcat{!!$cat->id!!}" aria-expanded="false" aria-controls="subcat{!!$cat->id!!}">{!!count($cat->subcat)!!}</span>
			    		<div class="collapse mt-2" id="subcat{!!$cat->id!!}">
			    			<div class="d-block border p-1 bg-white rounded">
			    				@foreach($cat->subcat as $subcat)
			    				<button type="button" class="btn btn-sm btn-success" onclick="addcategory('{!!$subcat->id!!}');"><span class="badge badge-success">{!!$subcat->title!!}</span></button>
			    				@endforeach
			    			</div>
			    		</div>
			    		@endif
			    	</td>
			    	<td>
			    		{!!$cat->created_at!!}
			    	</td>
			    	<td>
			    		<button type="button" class="btn btn-sm btn-primary" onclick="addcategory('{!!$cat->id!!}');"><i class="fas fa-pencil-alt"></i></button>
			    		<button type="button" class="btn btn-sm btn-danger" onclick="delcategory('{!!$cat->id!!}');"><i class="fas fa-trash-alt"></i></button>
			    	</td>
			    </tr>
			    @endforeach
			@else
			<tr>
				<td colspan="8" class="text-center">
					{!!trans('Langcore::global.EmptyRow')!!}
				</td>
			</tr>
			@endif
		</tbody>
	</table>
	{!!$paginator!!}
</div>