<?php
namespace Modules\Pages;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageGroups;

$menus = [];
$pages = Pages::with(['slug'])->where('active',1)->orderByDesc('id')->get();
$groups = PageGroups::orderByDesc('id')->get();
foreach ($groups as $group) {
	$url = route('pages.web.group',['slug'=>$group->slug->slug]);
	$menus[transmod('Pages::PageGroups')][$url] = $group->title;
}
foreach ($pages as $page) {
	$url = route('pages.web.page',['slug'=>$page->slug->slug]);
	$menus[transmod('Pages::ListPages')][$url] = $page->title;
}