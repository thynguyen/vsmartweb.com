<?php

namespace Modules\News\Entities;

use Modules\Search\ModuleSearchable;
use Modules\Search\ModuleSearchResult;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Model;
use Vsw\Comment\Models\Comment;
use Core\Models\Slugs;
use Modules\News\Entities\CatPost;
use App\User;
use AdminFunc;

class News extends Model implements ModuleSearchable
{
    public $searchableType;
    protected $table;
    protected $fillable = ['title', 'content', 'description','keyword','active','user_id','image','views'];
    
    public function __construct()
	{
		$this->table = 'vsw_'.LaravelLocalization::getCurrentLocale().'_news';
        $this->searchableType = AdminFunc::ReturnModule('News','title');
	}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function slug()
    {
        return $this->hasOne(Slugs::class, 'item_id')->where('module','News')->where('locale',LaravelLocalization::getCurrentLocale());
    }
    public function cat()
    {
        return $this->hasOne(CatPost::class, 'newid');
    }
    public function catpost()
    {
        return $this->hasMany(CatPost::class, 'newid');
    }
	public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id')->where('module','News')->where('active',1)->whereNull('parent_id')->orwhere('parent_id',0);
    }
    public function getSearchResult(): ModuleSearchResult
    {
        $url = route('news.web.detail',['slug'=>$this->slug->slug]);

        return new ModuleSearchResult(
            $this,
            $this->title,
            $url,
            $this->description,
            $this->image
        );
    }
}
