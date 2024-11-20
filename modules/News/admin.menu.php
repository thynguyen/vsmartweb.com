<?php

$submenu = [];
if (AdminFunc::ReturnModule('News','active')==1) {
	$submenu = [
		'title'=> AdminFunc::ReturnModule('News','title'),
		'route'=> route('news.admin.main'),
		'icon'=> '<i class="'.AdminFunc::ReturnModule('News','icon').'"></i>',
		'permission'=>1,
		'active' => AdminFunc::ReturnModule('News','active'),
		'path'=>'News',
		'submenu'=> [
			[
				'title' => transmod('News::ListNews'),
				'route' => route('news.admin.main'),
				'icon' => '<i class="fal fa-envelope-open-text"></i>'
			],
			[
				'title' => transmod('News::CatalogNews'),
				'route' => route('news.admin.category'),
				'icon' => '<i class="fas fa-clipboard-list"></i>'
			],
			[
				'title' => trans('Langcore::config.ConfigModule'),
				'route' => route('news.admin.config'),
				'icon' => '<i class="fas fa-cogs"></i>'
			]
		]
	];
}