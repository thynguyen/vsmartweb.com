<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Contact\Entities\Contact;
use App\User;

class ReplyContact extends Model
{
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_contact_reply';
	}
	public function contact(){
		return $this->hasOne(Contact::class,'contactid');
	}
	public function auth(){
		return $this->hasOne(User::class,'id','authid');
	}
}
