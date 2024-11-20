<?php
$submenu = [];
if (AdminFunc::ReturnModule('Sliders','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Sliders','title'),
		'route'=> route('sliders.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Sliders','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Sliders','active'),
		'path'=>'Sliders',
		'submenu'=> []
	];
}