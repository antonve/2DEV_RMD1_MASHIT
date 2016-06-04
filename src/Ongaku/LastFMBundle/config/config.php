<?php

// config.php - ExampleBundle configuration
// By Anton Van Eechaute

return array(
    'namespace' => 'Ongaku',
    'name'      => 'LastFMBundle',
    'routes'    => false,
    'init'      => false,
    'smarty'    => false,
    'services'  => array(
         array (
        'name' => 'lastfm',
        'class' => '\Ongaku\LastFMBundle\Services\LastFMService',
        'config' => array(
                'api_key' => '<redacted>',
                'url' => 'http://ws.audioscrobbler.com/2.0/?',
                'format' => 'json', // or xml
                'api_cache_prefix' => 'lfm_'
            ),
        ),
    ),
);
