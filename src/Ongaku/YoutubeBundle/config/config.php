<?php

// config.php - ExampleBundle configuration
// By Anton Van Eechaute

return array(
    'namespace' => 'Ongaku',
    'name'      => 'YoutubeBundle',
    'routes'    => false,
    'init'      => false,
    'smarty'    => false,
    'services'  => array(
         array (
        'name' => 'youtube',
        'class' => '\Ongaku\YoutubeBundle\Services\YoutubeService',
        'config' => array(
                'url' => 'https://gdata.youtube.com/feeds/api/',
                'format' => 'json', // or xml
                'api_cache_prefix' => 'yt_'
            ),
        ),
    ),
);
