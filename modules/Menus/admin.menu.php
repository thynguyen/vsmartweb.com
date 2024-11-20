<?php

$submenu = [];
if (AdminFunc::ReturnModule('Menus','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Menus','title'),
		'route'=> route('menus.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Menus','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Menus','active'),
		'path'=>'Menus',
		'submenu'=> []
	];
}