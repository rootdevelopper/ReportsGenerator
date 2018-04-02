<?php
require __DIR__ . "/vendor/autoload.php";

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

function Parameters(): void
{
//db parameters
    define('DB_HOST', getenv('DB_HOST'));
    define('DB_USER', getenv('DB_USER'));
    define('DB_PASS', getenv('DB_PASS'));
    define('DB_NAME', getenv('DB_NAME'));
    define('ROOT_PATH', __DIR__ . '/');
    define('APPLICATION_NAME', 'Drive API PHP Quickstart');
    define('CREDENTIALS_PATH', __DIR__ . '/credentials/drive-php-quickstart.json');
    define('CLIENT_SECRET_KEYS', 'client_secret.json');
    define('CLIENT_ID', getenv('CLIENT_ID'));
    define('PROJECT_ID', getenv('PROJECT_ID'));
    define('AUTH_URI', getenv('AUTH_URI'));
    define('TOKEN_URI', getenv('TOKEN_URI'));
    define('AUTH_PROVIDER', getenv('AUTH_PROVIDER'));
    define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
    define('REDIRECT_URIS', getenv('REDIRECT_URIS'));
    define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
    define('SCOPES', implode(' ', array(
            Google_Service_Drive::DRIVE)
    ));
}

Parameters();