<?php

// BundleLoader.php - make php services easily available in controllers
// By Anton Van Eechaute

namespace Devine\Framework;

/**
 * A class to load bundles
 */
class BundleLoader
{
    /**
     * An array with strings that represent bundles
     * @var array
     */
    private $bundles = array();

    /**
     * An array with loaded bundles
     * @var array
     */
    private $loaded = array();

    /**
     * An array containing all the routes
     * @var array
     */
    private $routes;

    /**
     *
     * @var Collection
     */
    private $services;

    /**
     * @var BundleClassLoader
     */
    private $bundleClassLoader;

    /**
     * @var \Smarty
     */
    private $smarty;

    /**
     * @var array
     */
    private $initPaths = array();

    /**
     * @param array $bundles
     * @param BundleClassLoader $bundleClassLoader
     */
    function __construct($bundles, BundleClassLoader $bundleClassLoader, \Smarty $smarty)
    {
        $this->bundles = $bundles;
        $this->routes = new RouteCollection();
        $this->bundleClassLoader = $bundleClassLoader;
        $this->services = new Collection();
        $this->smarty = $smarty;
    }

    /**
     * Load all configured bundles
     * @param $path path to where bundles live
     * @throws \Exception
     */
    public function load($path)
    {
        foreach ($this->bundles as $bundle) {
            if (file_exists($path . $bundle . '/config/config.php')) {
                $loadedBundle = new Bundle(
                    array_merge(
                        include ($path . $bundle . '/config/config.php'),
                        array ('path' => $path . $bundle)
                    )
                );
                $loadedBundle->load();
                $this->bundleClassLoader->register($loadedBundle->getNamespace());

                if ($loadedBundle->hasSmarty()) {
                    $this->smarty->addTemplateDir($path . $bundle . '/templates/');
                }

                $this->loaded[] = $loadedBundle;
            } else {
                throw new \Exception('Bundle \'' . $path . $bundle . '\'not found.');
            }
        }
    }

    /**
     * Get all the routes, if empty get all
     * @return array
     */
    public function getRoutes()
    {
        if ($this->routes->isEmpty()) {
            foreach ($this->loaded as $bundle) {
                if (null !== $bundle->getRoutes()) {
                    $this->routes->addCollection($bundle->getRoutes());
                }
            }
        }

        return $this->routes;
    }

    /**
     * Get all services
     * @return array
     */
    public function getServices()
    {
        if ($this->services->isEmpty()) {
            foreach ($this->loaded as $bundle) {
                $this->services->addArray($bundle->getServices());
            }
        }

        return $this->services;
    }

    /**
     * Get all init paths
     * @return array
     */
    public function getInitPaths()
    {
        if (empty($this->initPaths)) {
            foreach ($this->loaded as $bundle) {
                if ($bundle->hasInit()) {
                    $this->initPaths[] = $bundle->getPath() . '/config/init.php';
                }
            }
        }

        return $this->initPaths;
    }

}
