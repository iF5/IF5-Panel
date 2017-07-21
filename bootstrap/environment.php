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

$envName = ($_SERVER['SERVER_NAME'] === 'localhost') ? 'local' : 'production';

$env = $app->detectEnvironment(function () use ($envName) {
    $envPath = sprintf('%s/../.%s', __DIR__, $envName);

    if (file_exists(sprintf('%s/.env', $envPath))) {
        $dotenv = new Dotenv\Dotenv($envPath);
        $dotenv->overload(); //this is important
    }
});
