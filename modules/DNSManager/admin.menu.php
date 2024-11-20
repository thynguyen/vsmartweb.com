<?php

$submenu = [];
if (AdminFunc::ReturnModule('DNSManager','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('DNSManager','title'),
		'route'=> route('dnsmanager.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('DNSManager','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('DNSManager','active'),
		'path'=>'DNSManager',
		'submenu'=> [
			// [
			// 	'title' => AdminFunc::ReturnModule('DNSManager','title'),
			// 	'route' => route('dnsmanager.admin.main'),
			// 	'icon' => '<i class="fal fa-envelope-open-text"></i>'
			// ]
		]
	];
}