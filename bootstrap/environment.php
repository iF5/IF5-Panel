<?php

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

$envName = (file_exists(sprintf('%s/../.localhost', __DIR__))) ? 'local' : 'production';

define('IF5_ENV', $envName);

$env = $app->detectEnvironment(function () use ($envName) {
    $envPath = sprintf('%s/../.%s', __DIR__, $envName);
    if (file_exists(sprintf('%s/.env', $envPath))) {
        $dotenv = new Dotenv\Dotenv($envPath);
        $dotenv->overload(); //this is important
    }
});
