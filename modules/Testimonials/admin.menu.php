<?php

$submenu = [];
if (AdminFunc::ReturnModule('Testimonials','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Testimonials','title'),
		'route'=> route('testimonials.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Testimonials','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Testimonials','active'),
		'path'=>'Testimonials',
		'submenu'=> []
	];
}