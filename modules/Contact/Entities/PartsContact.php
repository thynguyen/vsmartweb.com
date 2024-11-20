<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Contact\Entities\PartsContactEmail;

class PartsContact extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_contact_parts';
	}
	public function partsemail(){
		return $this->hasMany(PartsContactEmail::class,'partid');
	}
}
