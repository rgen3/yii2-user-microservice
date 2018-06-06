<?php
declare(strict_types = 1);

return [
    // url => controller
    'GET info' => 'info/info',
    'GET test' => 'info/test',
    'POST info/json-request' => 'info/json-schema',
    'GET info/exception' => 'info/exception',
    'GET info/render-model' => 'info/render-model',
    // user router
    'POST login' => 'auth/login',
    'POST logout' => 'auth/logout',
    'POST registration' => 'auth/registration',
    // security
    'POST verify-token' => 'security/verify-token',
    'POST revoke-token' => 'security/revoke-token',
    'POST refresh-token' => 'security/refresh-token',
    'GET get-public-key' => 'security/get-public-key',
];