<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\News\Entities\News;
use Modules\News\Entities\CatalogNews;

class CatPost extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_news_catpost';
	}

    public function news()
    {
        return $this->hasOne(News::class, 'id','newid')->where('active',1);
    }
    public function cat()
    {
        return $this->hasOne(CatalogNews::class, 'id','catid');
    }
}
