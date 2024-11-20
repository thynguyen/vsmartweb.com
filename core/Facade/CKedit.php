<?php

namespace Core\Facade;
use Illuminate\Support\Facades\Facade;

class CKedit extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ckediter';
    }
}
