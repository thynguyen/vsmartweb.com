<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Slugs extends Model
{
	use Sluggable;
    protected $table = 'vsw_slugs';
    // protected $primaryKey = 'pathmod';
	public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
