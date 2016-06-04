<?php

// config.php - ApiBundle configuration
// By Anton Van Eechaute

return array(
    'namespace' => 'Devine',
    'name'      => 'ApiBundle',
    'routes'    => false,
    'init'      => false,
    'smarty'    => false,
    'services'  => array(
        array (
            'name' => 'cache',
            'class' => '\Devine\ApiBundle\Services\CacheService',
            'config' => array(),
        ),
    ),
);
