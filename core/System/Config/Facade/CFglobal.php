<?php

namespace Vsw\Config\Facade;
use Illuminate\Support\Facades\Facade;

class CFglobal extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cfglobal';
    }
}
