<?php

return [

    /*
    * Paths that should accept CORS requests.
    *
    * You can use wildcards (*) to match all paths.
    */
    'paths' => ['*'],

    /*
    * Allowed methods for CORS requests.
    *
    * You can specify all allowed methods using ['*']
    */
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    /*
    * Allowed headers for CORS requests.
    *
    * You can use ['*'] to allow all headers.
    */
    'allowed_headers' => ['*'],

    /*
    * Allowed HTTP verbs for pre-flight OPTIONS requests.
    *
    * You can use ['*'] to allow all verbs.
    */
    'allowed_origins' => ['*'], // Replace with specific origins if needed

    /*
    * Enables "Access-Control-Allow-Origin" header when the request origin domain is the same
    * as the server domain.
    */
    'supports_credentials' => false,

    /*
    * Enables "Access-Control-Expose-Headers" for headers that are not mentioned in "allowed_headers"
    * but may be accessed by CORS requests.
    */
    'exposed_headers' => [],

    /*
    * Max age for the pre-flight options cache.
    */
    'max_age' => 60,

    /*
    * Fallback for situations when `Access-Control-Allow-Origin` is not set.
    */
    'fallback_origin' => null,

    /*
    * Skip CORS checks for internal requests, where the origin domain
    * matches the server domain.
    */
    'skip_same_origin' => false,
];