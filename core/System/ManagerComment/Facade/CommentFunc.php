<?php

namespace Vsw\Comment\Facade;
use Illuminate\Support\Facades\Facade;

class CommentFunc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'comment';
    }
}
