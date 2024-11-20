<?php

namespace Vsw\Themes\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $table;    
    // protected $primaryKey = 'func_id';
    public $timestamps = false;
    public function __construct()
	{
		$this->table = 'vsw_modlayout';
	}
}
