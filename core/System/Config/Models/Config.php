<?php

namespace Vsw\Config\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'vsw_config';
    protected $primaryKey = 'config_name';
    public $timestamps = false;
}
