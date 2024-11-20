<?php
$submenu = [ 
	'title'=> trans('Langcore::config.Config'),
	'route'=>route('siteconfig'),
	'icon'=>'<i class="nav-icon icon-settings"></i>',
	'permission'=>0,
	'submenu'=>[
		[
			'title' => trans('Langcore::config.config_site'),
			'route' => route('siteconfig'),
			'icon' => '<i class="nav-icon icon-wrench"></i>',			
			'permission'=>0
		],
		[
			'title' => trans('Langcore::config.config_global'),
			'route' => route('globalconfig'),
			'icon' => '<i class="fal fa-tools"></i>',			
			'permission'=>0
		],
		[
			'title' => trans('Langcore::config.Update'),
			'route' => route('updatecore'),
			'icon' => '<i class="fal fa-cloud-upload"></i>',			
			'permission'=>0
		]
	]
];