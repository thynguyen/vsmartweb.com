<?php
$submenu = [];
if (AdminFunc::ReturnModule('Contact','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('Contact','title'),
		'route'=> route('contact.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('Contact','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('Contact','active'),
		'path'=>'Contact',
		'submenu'=> [
			[
				'title' => AdminFunc::ReturnModule('Contact','title'),
				'route' => route('contact.admin.main'),
				'icon' => '<i class="fal fa-envelope-open-text"></i>'
			],
			[
				'title' => transmod('Contact::Parts'),
				'route' => route('contact.admin.parts'),
				'icon' => '<i class="fal fa-briefcase"></i>'
			]
		]
	];
}