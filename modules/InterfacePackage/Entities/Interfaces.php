<?php

namespace Modules\InterfacePackage\Entities;

use Modules\Search\ModuleSearchable;
use Modules\Search\ModuleSearchResult;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\InterfacePackage\Entities\InterfaceCat;
use Modules\InterfacePackage\Entities\Sentiment;
use Modules\ServicePack\Entities\ServicePack;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Vsw\Comment\Models\Comment;
use AdminFunc,Auth;

class Interfaces extends Model implements ModuleSearchable
{
    use HasEagerLimit;
    public $searchableType;
    protected $fillable = [];
    protected $table;
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_interfacepackage';
        $this->searchableType = AdminFunc::ReturnModule('InterfacePackage','title');
	}
    public function cat(){
        return $this->hasOne(InterfaceCat::class,'id','catid');
    }
    public function servicepack(){
    	return $this->hasOne(ServicePack::class,'code','svp_code');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id')->where('module','InterfacePackage')->where('active',1)->whereNull('parent_id')->orwhere('parent_id',0);
    }
    public function vote()
    {
        return $this->hasMany(Comment::class, 'item_id')->whereNull('parent_id')->where('module','InterfacePackage')->where('active',1)->where('vote','>',0);
    }
    public function authsentiment(){
        $userid = (Auth::check())?Auth::user()->id:'null';
        return $this->hasOne(Sentiment::class,'interfaceid','id')->where('userid',$userid);
    }
    public function sentiment(){
        return $this->hasMany(Sentiment::class,'interfaceid','id');
    }
    public function sentimentlike(){
        return $this->hasMany(Sentiment::class,'interfaceid','id')->where('sentiment','like');
    }
    public function sentimentdislike(){
        return $this->hasMany(Sentiment::class,'interfaceid','id')->where('sentiment','dislike');
    }
    public function getSearchResult(): ModuleSearchResult
    {
        $url = route('interfacepackage.web.detail',['slug'=>$this->slug]);
        return new ModuleSearchResult(
            $this,
            $this->title,
            $url,
            $this->description,
            $this->image
        );
    }
}
