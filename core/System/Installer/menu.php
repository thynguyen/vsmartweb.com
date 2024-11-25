<?php
namespace Installer;
$menu = [
	[
		'step'=>1,
		'title'=>trans('Langcore::installer.LicenseCode'),
		'description'=>'',
		'link'=>route('installer.web.main')
	],
	[
		'step'=>2,
		'title'=>trans('Langcore::installer.ServerRequirements'),
		'description'=>'',
		'link'=>route('installer.web.requirements')
	],
	[
		'step'=>3,
		'title'=>trans('Langcore::installer.CheckPermissions'),
		'description'=>'',
		'link'=>route('installer.web.permissions')
	],
	[
		'step'=>4,
		'title'=>trans('Langcore::installer.Database'),
		'description'=>'',
		'link'=>route('installer.web.database')
	],
	[
		'step'=>5,
		'title'=>trans('Langcore::global.Config'),
		'description'=>'',
		'link'=>route('installer.web.configenv')
	],
	[
		'step'=>6,
		'title'=>trans('Langcore::installer.AdminAccount'),
		'description'=>'',
		'link'=>route('installer.web.createadmin')
	],
	[
		'step'=>7,
		'title'=>trans('Langcore::installer.CompleteInstallation'),
		'description'=>'',
		'link'=>route('installer.web.finish')
	],
];