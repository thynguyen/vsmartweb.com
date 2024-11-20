<?php
namespace Modules\News;
use Modules\News\Entities\CatalogNews;

$menus = [];
$categorys = CatalogNews::with(['slug'])->orderByDesc('id')->get();
foreach ($categorys as $cat) {
	$url = route('news.web.cat',['slug'=>$cat->slug->slug]);
	$menus[$url] = $cat->title;
}