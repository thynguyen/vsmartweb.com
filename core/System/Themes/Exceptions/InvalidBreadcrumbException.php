<?php

namespace Vsw\Themes\Exceptions;

use Vsw\Themes\BreadcrumbsException;

/**
 * Exception that is thrown if the user attempts to generate breadcrumbs for a page that is not registered.
 */
class InvalidBreadcrumbException extends BreadcrumbsException
{
}
