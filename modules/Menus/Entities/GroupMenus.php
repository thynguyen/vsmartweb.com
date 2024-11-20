<?php

namespace Modules\Menus\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Menus\Entities\Menus;

class GroupMenus extends Model
{
    protected $table;
    protected $fillable = ['title', 'description'];
	public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_menus_group';
	}
	public function menu(){
		return $this->hasMany(Menus::class, 'groupid');
	}
}
