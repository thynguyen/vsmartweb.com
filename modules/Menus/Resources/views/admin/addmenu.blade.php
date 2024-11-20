@php
$link = ($menu && $menu->route)?url($menu->route):'';
@endphp
<div class="card">
	<div class="card-body">
		{!!Form::hidden('parentold',$menu['parentid'],['id'=>'parentold'])!!}
		<div class="form-group">
			{!!Form::label('title', transmod('Menus::title'), ['class' => 'form-col-form-label']);!!}
			<div class="input-group">
				<div class="input-group-prepend">
					{!!$list_icons!!}
				</div>
				{!! Form::text('title', !empty($menu['id'])? $menu['title'] :'', ['class' => $errors->has('title') ? 'form-control ml-2 rounded-left is-invalid' : 'form-control ml-2 rounded-left','id'=>'title']) !!}
			</div>
			@if ($errors->has('title'))
			<div class="invalid-feedback">
				{{ $errors->first('title') }}
			</div>
			@endif
		</div>
		<div class="form-group row">
			{!!Form::label('parentid', transmod('Menus::parent_menu'), ['class' => 'form-col-form-label col-md-3']);!!}
			<div class="col-md-9">
				<select class="{{$errors->has('parentid') ? 'form-control is-invalid' : 'form-control'}}" id="parentid" name="parentid">
					<option value="0">--</option>
					@if(!empty($menus))
					{!!$menus!!}
					@endif
				</select>
			</div>
		</div>
		<div class="form-group">			
			{!!Form::radio('urltype', 'url', (!empty($menu['urltype']) && $menu['urltype'] == 'url')? true : false,['class' => 'form-check-label', 'id'=>'type_url']);!!}{!!Form::label('type_url', transmod('Menus::type_url'), ['class' => 'form-col-form-label']);!!}
			{!!Form::radio('urltype', 'route',(!empty($menu['urltype']) && $menu['urltype'] == 'route' or empty($menu['urltype']))? true : false,['class' => 'form-check-label', 'id'=>'type_route']);!!}{!!Form::label('type_route', transmod('Menus::type_route') , ['class' => 'form-col-form-label']);!!}
		</div>
		<div class="form-group row" style="display: {{($menu['urltype'] == 'url')? 'flex':'none'}}" id="typeurl">
			{!!Form::label('url', transmod('Menus::type_url'), ['class' => 'form-col-form-label col-md-3']);!!}
			<div class="col-md-9">
				{!! Form::text('url', !empty($menu['id'])? $menu['url'] :'', ['class' => $errors->has('url') ? 'form-control is-invalid' : 'form-control','id'=>'url']) !!}
			</div>
		</div>
		<div style="display: {{($menu['urltype'] == 'route' or empty($menu['urltype']))? 'block':'none'}}" id="typeroute">
			<div class="form-group row">
				{!!Form::label('route', transmod('Menus::type_route'), ['class' => 'form-col-form-label col-md-3']);!!}
				<div class="col-md-9">
					<div class="row">
						<div class="col-sm-6">
							{!!Form::select('module', ['index'=>trans('Langcore::global.home')]+$list_module, $menu['module'], ['class' => 'form-control', 'id'=>'module', 'onchange'=>'getlistmenumod(this,"'.$link.'");'])!!}
						</div>
						<div class="col-sm-6">
							<div id="showlistmenumod"></div>
						</div>
					</div>
					<div id="showurl" class="my-2 badge badge-success">{!!$link!!}</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			{!!Form::label('target', 'Target', ['class' => 'form-col-form-label col-md-3']);!!}
			<div class="col-md-9">
				{!!Form::select('target', $list_target, $menu['target'], ['class' => 'form-control', 'id'=>'target'])!!}
			</div>
		</div>
		<button class="btn btn-sm btn-primary" type="button" onclick="submitaddmenu({!!$groupid!!},{!!($menu)?$menu['id']:'null'!!})">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
		<button type="button" class="btn btn-sm btn-danger" onclick="closeform()">{{trans('Langcore::global.Cancel')}}</button>
	</div>
</div>
@if($menu)
<script type="text/javascript">
	getlistmenumod('#module','{!!$link!!}');
</script>
@endif