<?php
$submenu = [
	'title'=> trans('Langcore::themes.MainThemes'),
	'route'=>route('AdminThemes'),
	'icon'=>'<i class="fas fa-palette"></i>',
	'permission'=>1,
	'submenu'=>[
		[
			'title' => trans('Langcore::themes.ManagerThemes'),
			'route' => route('AdminThemes'),
			'icon' => '<i class="fas fa-paint-roller"></i>',
			'permission'=>0
		],[
			'title' => trans('Langcore::themes.LayoutSetup'),
			'route' => route('layoutsetup'),
			'icon' => '<i class="fab fa-elementor"></i>',
			'permission'=>0
		],[
			'title' => trans('Langcore::themes.ManagerWidget'),
			'route' => route('Widget'),
			'icon' => '<i class="fas fa-shapes"></i>',
			'permission'=>1
		]
	]
];