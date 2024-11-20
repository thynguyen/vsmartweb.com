<?php

$submenu = [];
if (AdminFunc::ReturnModule('ServicePack','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('ServicePack','title'),
		'route'=> route('servicepack.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('ServicePack','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('ServicePack','active'),
		'path'=>'ServicePack',
		'submenu'=> [
			[
				'title' => AdminFunc::ReturnModule('ServicePack','title'),
				'route' => route('servicepack.admin.main'),
				'icon' => '<i class="fal fa-hand-holding-box"></i>'
			],
			[
				'title' => transmod('ServicePack::TransactionManagement'),
				'route' => route('servicepack.admin.transactionmanagement'),
				'icon' => '<i class="fal fa-bags-shopping"></i>'
			]
		]
	];
}