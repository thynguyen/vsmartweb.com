<?php

namespace Modules\Pages\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Pages\Entities\Pages;
use Core\Models\Slugs;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageGroups extends Model
{
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_pages_groups';
	}
	public function pages(){
    	return $this->hasMany(Pages::class,'groupid','id');
    }
    public function slug()
    {
        return $this->hasOne(Slugs::class, 'item_id')->where('module','PageGroup')->where('locale',LaravelLocalization::getCurrentLocale());
    }
}
