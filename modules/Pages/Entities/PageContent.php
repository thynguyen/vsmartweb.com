<?php

namespace Modules\Pages\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Pages\Entities\Pages;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageContent extends Model
{
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_pages_content';
	}
    public function page(){
    	return $this->hasOne(Pages::class,'id','pageid');
    }
}
