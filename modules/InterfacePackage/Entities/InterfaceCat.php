<?php

namespace Modules\InterfacePackage\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\InterfacePackage\Entities\Interfaces;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class InterfaceCat extends Model
{
    use HasEagerLimit;
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_interface_catalogs';
	}
	public function interface(){
		return $this->hasMany(Interfaces::class,'catid','id');
	}
    public function catparent()
    {
        return $this->hasOne(InterfaceCat::class,'id','parentid');
    }
}
