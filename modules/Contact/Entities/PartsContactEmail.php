<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Contact\Entities\PartsContact;
use App\User;

class PartsContactEmail extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_contact_parts_email';
	}
	public function part(){
		return $this->hasOne(PartsContact::class,'partid');
	}
	public function user(){
		return $this->hasOne(User::class,'id','userid');
	}
}
