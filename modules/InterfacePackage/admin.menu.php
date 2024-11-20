<?php

$submenu = [];
if (AdminFunc::ReturnModule('InterfacePackage','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('InterfacePackage','title'),
		'route'=> route('interfacepackage.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('InterfacePackage','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('InterfacePackage','active'),
		'path'=>'InterfacePackage',
		'submenu'=> [
			[
				'title' => transmod('InterfacePackage::ManagementInterface'),
				'route' => route('interfacepackage.admin.main'),
				'icon' => '<i class="fal fa-list-alt"></i>'
			],
			[
				'title' => transmod('InterfacePackage::Category'),
				'route' => route('interfacepackage.admin.category'),
				'icon' => '<i class="fal fa-list-alt"></i>'
			],
			[
				'title' => trans('Langcore::config.ConfigModule'),
				'route' => route('interfacepackage.admin.config'),
				'icon' => '<i class="fas fa-cogs"></i>'
			]
		]
	];
}