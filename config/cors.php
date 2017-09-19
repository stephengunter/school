<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],    
   
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    //'allowedHeaders' => ['Content-Type', 'X-Requested-With'],
    'maxAge' => 0,
    'hosts' => [],
];

