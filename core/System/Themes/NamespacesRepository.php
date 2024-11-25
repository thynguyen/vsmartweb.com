<?php

namespace Vsw\Themes;

use Vsw\Themes\Misc\NamespaceNotFoundException;

class NamespacesRepository
{
    /**
     * The array of namespaces.
     *
     * @var array
     */
    protected $namespaces;

    /**
     * Register a namespace.
     *
     * @param string $alias
     * @param string $namespace
     *
     * @return WidgetNamespaces
     */
    public function registerNamespace($alias, $namespace)
    {
        $this->namespaces[$alias] = rtrim($namespace, '\\');

        return $this;
    }

    /**
     * Get namespace by his alias.
     *
     * @param string $label
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getNamespace($alias)
    {
        if (!isset($this->namespaces[$alias])) {
            throw new NamespaceNotFoundException('Namespace not found with the alias "'.$alias.'"');
        }

        return $this->namespaces[$alias];
    }
}
