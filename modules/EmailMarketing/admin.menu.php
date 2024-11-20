<?php

$submenu = [];
if (AdminFunc::ReturnModule('EmailMarketing','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('EmailMarketing','title'),
		'route'=> route('emailmarketing.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('EmailMarketing','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('EmailMarketing','active'),
		'path'=>'EmailMarketing',
		'submenu'=> [
			[
				'title' => transmod('EmailMarketing::EmailSubscribe'),
				'route' => route('emailmarketing.admin.main'),
				'icon' => '<i class="fas fa-tasks"></i>'
			],
			[
				'title' => transmod('EmailMarketing::Campaign'),
				'route' => route('emailmarketing.admin.campaign'),
				'icon' => '<i class="fas fa-tasks"></i>'
			],
			[
				'title' => transmod('EmailMarketing::VerifiedDomains'),
				'route' => route('emailmarketing.admin.verifieddomains'),
				'icon' => '<i class="fas fa-tasks"></i>'
			],
			[
				'title' => trans('Langcore::config.ConfigModule'),
				'route' => route('emailmarketing.admin.config'),
				'icon' => '<i class="fas fa-cogs"></i>'
			]
		]
	];
}