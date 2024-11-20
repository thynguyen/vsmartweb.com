<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Contact\Entities\PartsContact;
use Modules\Contact\Entities\CustomerContact;
use Modules\Contact\Entities\ReplyContact;

class Contact extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_contact';
	}
	public function part(){
		return $this->hasOne(PartsContact::class,'id','partid');
	}
	public function customer(){
		return $this->hasOne(CustomerContact::class,'id','customerid');
	}
	public function reply(){
		return $this->hasMany(ReplyContact::class,'contactid','id');
	}
}
