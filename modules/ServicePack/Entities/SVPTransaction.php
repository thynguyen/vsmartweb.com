<?php

namespace Modules\ServicePack\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\ServicePack\Entities\SVPReg;
use Modules\ServicePack\Entities\ServicePack;
use Modules\ServicePack\Entities\SVPTransLog;
use App\User;

class SVPTransaction extends Model
{
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_servicepack_transaction';
	}
    public function svpack(){
        return $this->hasOne(ServicePack::class,'code','svp_code');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }
    public function log(){
        return $this->hasMany(SVPTransLog::class,'transid');
    }
}
