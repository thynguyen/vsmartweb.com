<?php

namespace Modules\Sliders\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Sliders\Entities\Sliders;

class SldTemp extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_sliders_temp';
	}
}
