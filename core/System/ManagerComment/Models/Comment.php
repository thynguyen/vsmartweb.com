<?php
  
namespace Vsw\Comment\Models;
  
use Illuminate\Database\Eloquent\Model;
use App\User;
  
class Comment extends Model
{
    protected $table = 'vsw_comments';
    protected $dates = ['deleted_at'];

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'email',
        'user_id', 
        'item_id', 
        'parent_id', 
        'comment',
        'vote', 
        'module',
        'locale',
        'active'
    ];
   
    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('active',1);
    }
    public function parentreply()
    {
        return $this->hasOne(Comment::class,'id', 'parent_id')->where('active',1);
    }
    public function adminreplies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}