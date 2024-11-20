<?php
namespace Modules\InterfacePackage;
use Modules\InterfacePackage\Entities\InterfaceCat;

$menus = [];
$categorys = InterfaceCat::orderByDesc('id')->get();
foreach ($categorys as $cat) {
	$url = route('interfacepackage.web.viewcat',['slug'=>$cat->slug]);
	$menus[$url] = $cat->title;
}