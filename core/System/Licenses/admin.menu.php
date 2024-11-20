<?php
$submenu = [ 
	'title'=> trans('Langcore::licenses.LicensingManagement'),
	'route'=>route('licenses.admin.main'),
	'icon'=>'<i class="fas fa-file-certificate"></i>',
	'permission'=>0,
	'submenu'=>[
		[
			'title' => trans('Langcore::licenses.License'),
			'route' => route('licenses.admin.main'),
			'icon' => '<i class="fas fa-file-certificate"></i>',
			'permission'=>0
		],
		[
			'title' => trans('Langcore::licenses.ManageVersions'),
			'route' => route('licenses.admin.manageversions'),
			'icon' => '<i class="fas fa-file-certificate"></i>',
			'permission'=>0
		],
	]
];