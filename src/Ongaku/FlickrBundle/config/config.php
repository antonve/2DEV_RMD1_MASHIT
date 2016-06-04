<?php

// config.php - ExampleBundle configuration
// By Anton Van Eechaute

return array(
    'namespace' => 'Ongaku',
    'name'      => 'FlickrBundle',
    'routes'    => false,
    'init'      => false,
    'smarty'    => false,
    'services'  => array(
         array (
        'name' => 'flickr',
        'class' => '\Ongaku\FlickrBundle\Services\FlickrService',
        'config' => array(
                'api_key' => '<redacted>',
                'url' => 'http://api.flickr.com/services/rest/?',
                'format' => 'json',
                'api_cache_prefix' => 'flkr_'
            ),
        ),
    ),
);
