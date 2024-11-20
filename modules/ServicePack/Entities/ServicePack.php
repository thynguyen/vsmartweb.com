<?php

namespace Modules\ServicePack\Entities;

use Modules\Search\ModuleSearchable;
use Modules\Search\ModuleSearchResult;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Core\Models\Slugs;
use AdminFunc;

class ServicePack extends Model implements ModuleSearchable
{
    protected $fillable = [];
    public $searchableType;
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_servicepack';
        $this->searchableType = AdminFunc::ReturnModule('ServicePack','title');
	}
    public function getSearchResult(): ModuleSearchResult
    {
        $url = route('servicepack.admin.main');

        return new ModuleSearchResult(
            $this,
            $this->title,
            $url,
            $this->description
        );
    }
    public function slug()
    {
        return $this->hasOne(Slugs::class, 'item_id')->where('module','ServicePack')->where('locale',LaravelLocalization::getCurrentLocale());
    }
}
