<?php

namespace Vsw\Themes\Exceptions;

use Vsw\Themes\BreadcrumbsException;

/**
 * Exception that is thrown if the user attempts to render breadcrumbs without setting a view.
 */
class ViewNotSetException extends BreadcrumbsException
{
}
