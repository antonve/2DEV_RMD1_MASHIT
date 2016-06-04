<?php

namespace Devine\Framework;

/**
 * Helper class to use with SplClassLoader
 */
class BundleClassLoader
{
    /**
     * @var array
     */
    private $namespaces;

    /**
     * @var string
     */
    private $path;

    /**
     * @param $classLoader
     */
    function __construct($classLoader, $path)
    {
        $this->namespaces = array(
            'Devine' => $classLoader
        );
        $this->path = $path;
    }


    /**
     * Registers a new namespace using the SplClassLoader. It saves an array of namespaces that are already loaded.
     * @param $namespace
     * @param $path
     * @return bool
     */
    function register($namespace)
    {
        if (array_key_exists($namespace, $this->namespaces)) {
            return false;
        }

        $classLoader = new \SplClassLoader($namespace, $this->path);
        $classLoader->register();

        $this->namespaces[$namespace] = $classLoader;
        return true;
    }


}
