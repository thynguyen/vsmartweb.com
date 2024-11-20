<?php

namespace Vsw\Language\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'vsw_language';
    // protected $primaryKey = 'id';
    public $timestamps = false;

        /**
     * @var array
     */
    protected $fillable = [
        'name',
        'locale',
        'default',
        'code',
        'flag',
        'weight',
    ];

    public function scopeOfLangLocale($query)
    {
        return $query->where('active', 1)->select('name','locale','script','native','regional');
    }
}
