<?php

namespace Vsw\Themes\Misc;

use Exception;

class InvalidWidgetClassException extends Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'Widget class must extend Vsw\Themes\AbstractWidget class';
}
