<?php

namespace Vsw\Themes;

class AsyncFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'vswwidget.async-widget';
    }
}
