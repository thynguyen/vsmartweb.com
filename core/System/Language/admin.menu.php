<?php
$submenu = [ 
	'title'=> trans('Langcore::language.Language'),
	'route'=>route('listlang'),
	'icon'=>'<i class="fas fa-language"></i>',
	'permission'=>0,
	'submenu'=>[
		[
			'title' => trans('Langcore::language.ListLanguage'),
			'route' => route('listlang'),
			'icon' => '<i class="fas fa-flag-checkered"></i>',
			'permission'=>0
		],[
			'title' => trans('Langcore::language.ImportLanguage'),
			'route' => route('importlang'),
			'icon' => '<i class="fas fa-file-upload"></i>',
			'permission'=>0
		]
	]
];