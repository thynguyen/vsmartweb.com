<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Core\Models\Slugs;
use Modules\News\Entities\CatPost;

class CatalogNews extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_news_catalogs';
	}
    public function slug()
    {
        return $this->hasOne(Slugs::class, 'item_id')->where('module','CategoryNews')->where('locale',LaravelLocalization::getCurrentLocale());
    }
    
    public function catpost()
    {
        return $this->hasMany(CatPost::class, 'catid')->orderBy('newid', 'desc');
    }
    public function subcat()
    {
        return $this->hasMany(CatalogNews::class, 'parentid');
    }
    public function catparent()
    {
        return $this->hasOne(CatalogNews::class,'id','parentid');
    }
}
