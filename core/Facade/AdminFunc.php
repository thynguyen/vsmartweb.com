<?php

namespace Core\Facade;
use Illuminate\Support\Facades\Facade;

class AdminFunc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'adminfunctions';
    }
}
