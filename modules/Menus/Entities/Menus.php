<?php

namespace Modules\Menus\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Menus extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_menus';
	}
	public function submenus(){
		return $this->hasMany(Menus::class, 'parentid','id');
	}
}
