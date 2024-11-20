<?php
$submenu = [ 
	'title'=> trans('Langcore::permissions.Administrators'),
	'route'=> route('listadmin'),
	'icon'=>'<i class="fas fa-crown"></i>',
	'permission'=>0,
	'submenu'=>[
		[
			'title' => trans('Langcore::permissions.ListAdmin'),
			'route' => route('listadmin'),
			'icon' => '<i class="fas fa-user-secret"></i>',			
			'permission'=>0
		],
		[
			'title' => trans('Langcore::permissions.Roles'),
			'route' => route('listpermissions'),
			'icon' => '<i class="fas fa-star"></i>',			
			'permission'=>0
		]
	]
];