<?php

$submenu = [];
if (AdminFunc::ReturnModule('Pages','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Pages','title'),
		'route'=> route('pages.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Pages','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Pages','active'),
		'path'=>'Pages',
		'submenu'=> [
			[
				'title' => transmod('Pages::ListPages'),
				'route' => route('pages.admin.main'),
				'icon' => '<i class="fal fa-file-alt"></i>'
			],
			[
				'title' => transmod('Pages::PageGroups'),
				'route' => route('pages.admin.groups'),
				'icon' => '<i class="fal fa-clipboard-list-check"></i>'
			]
		]
	];
}