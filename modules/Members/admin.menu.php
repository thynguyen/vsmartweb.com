<?php

$submenu = [];
if (AdminFunc::ReturnModule('Members','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Members','title'),
		'route'=> route('members.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Members','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Members','active'),
		'path'=>'Members',
		'submenu'=> []
	];
}