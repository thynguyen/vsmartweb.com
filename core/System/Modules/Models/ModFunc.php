<?php

namespace Vsw\Modules\Models;

use Illuminate\Database\Eloquent\Model;

class ModFunc extends Model
{
    protected $table;
    public $timestamps = false;

    public function __construct()
	{
		$this->table = 'vsw_funcmod';
	}
}
