<?php

namespace Vsw\Language\Facade;
use Illuminate\Support\Facades\Facade;

class LanguageFunc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'languagefunctions';
    }
}
