<?php

namespace Modules\ServicePack\Entities;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\ServicePack\Entities\SVPTransLog;
use App\User;

class SVPTransLog extends Model
{
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_servicepack_translog';
	}
    public function trans(){
        return $this->hasOne(SVPTransLog::class,'transid');
    }
    public function handl()
    {
        return $this->belongsTo(User::class,'handler');
    }
}
