<?php

namespace Vsw\Themes\Exceptions;

use Vsw\Themes\BreadcrumbsException;

/**
 * Exception that is thrown if the user attempts to register two breadcrumbs with the same name.
 *
 * @see \Vsw\Themes\BreadcrumbsManager::register()
 */
class DuplicateBreadcrumbException extends BreadcrumbsException
{
}
