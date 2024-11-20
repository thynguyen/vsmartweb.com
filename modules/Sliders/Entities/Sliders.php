<?php

namespace Modules\Sliders\Entities;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Model;
use Modules\Sliders\Entities\SldTemp;
use AdminFunc,CFglobal;

class Sliders extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_sliders';
	}

    public function template(){
        return $this->hasOne(SldTemp::class, 'sliderid')->where('theme',CFglobal::cfn('theme'));
    }
}
