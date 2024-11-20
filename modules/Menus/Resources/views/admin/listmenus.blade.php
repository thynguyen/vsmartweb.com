<div class="card">
    <div class="card-body p-0">
    	<div class="m-3 d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{!!$group->title!!}</h4>
            <div>
            <button type="button" class="btn btn-sm btn-primary" onclick="addmenu('{!!$group->id!!}');"><i class="fal fa-bars mr-1"></i>{{transmod('Menus::add_menu')}}</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="loadlistmenu('{!!$group->id!!}');"><i class="fal fa-sync-alt"></i></button>
            </div>
        </div>
        <div id="listmenu" class="rounded">
        	{!!$menus!!}
        </div>
    </div>
</div>