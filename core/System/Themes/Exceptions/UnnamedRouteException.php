<?php

namespace Vsw\Themes\Exceptions;

use Vsw\Themes\BreadcrumbsException;

/**
 * Exception that is thrown if the user attempt to render breadcrumbs for the current route but the current route
 * doesn't have a name.
 */
class UnnamedRouteException extends BreadcrumbsException
{
}
