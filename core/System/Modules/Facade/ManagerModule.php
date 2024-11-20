<?php

namespace Vsw\Modules\Facade;

use Vsw\Modules\ModulesFunc;
use Illuminate\Support\Facades\Facade;

class ManagerModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // return 'managermodule';
        return ModulesFunc::class;
    }
}
