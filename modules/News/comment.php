<?php
namespace Modules\News;
use Modules\News\Entities\News;

$new = News::with(['slug'])->where('id',$comment->item_id)->first();
$arraycommnet = [
	'title'=>$new->title,
	'slug'=>$new->slug->slug,
	'link'=>route('news.web.detail',['slug'=>$new->slug->slug])
];