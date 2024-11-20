<?php

namespace Modules\Pages\Entities;

use Modules\Search\ModuleSearchable;
use Modules\Search\ModuleSearchResult;
use Illuminate\Database\Eloquent\Model;
use Modules\Pages\Entities\PageContent;
use Modules\Pages\Entities\PageGroups;
use Core\Models\Slugs;
use AdminFunc;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Pages extends Model implements ModuleSearchable
{
    protected $fillable = [];
    public $searchableType;
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_pages';
        $this->searchableType = AdminFunc::ReturnModule('Pages','title');
	}
    public function getSearchResult(): ModuleSearchResult
    {
        $url = route('pages.web.page',['slug'=>$this->slug->slug]);

        return new ModuleSearchResult(
            $this,
            $this->title,
            $url,
            $this->description,
            $this->image
        );
    }
	public function slug()
    {
        return $this->hasOne(Slugs::class, 'item_id')->where('module','Pages')->where('locale',LaravelLocalization::getCurrentLocale());
    }
    public function content(){
    	return $this->hasOne(PageContent::class,'pageid');
    }
    public function group(){
        return $this->hasOne(PageGroups::class,'id','groupid');
    }
}
