<?php

namespace Modules\ServicePack\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\ServicePack\Entities\ServicePack;
use App\User;

class SVPReg extends Model
{
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_servicepack_reg';
	}
    public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }
    public function servicepack(){
        return $this->hasOne(ServicePack::class,'code','svp_code');
    }
}
