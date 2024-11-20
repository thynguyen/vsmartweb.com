<?php

namespace Modules\InterfacePackage\Entities;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Modules\InterfacePackage\Entities\Interfaces;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\User;

class Sentiment extends Model
{
	use HasEagerLimit;
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_interface_sentiment';
	}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
	public function interface(){
		return $this->hasOne(Interfaces::class,'interfaceid');
	}
}
