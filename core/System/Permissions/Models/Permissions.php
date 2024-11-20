<?php

namespace Vsw\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Vsw\Permissions\Models\Roles;

class Permissions extends Model
{
    protected $table = 'vsw_permissions';
    // protected $primaryKey = 'pathmod';
    public function roles(){
    	return $this->hasMany(Roles::class,'per_id');
    }
}
