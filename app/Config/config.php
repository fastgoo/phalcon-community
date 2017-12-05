<?php

use Phalcon\Config;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => '5775d04228bfe.sh.cdb.myqcloud.com',
        'username' => 'cdb_outerroot',
        'password' => 'huoniaojungege@',
        'dbname' => 'wechat-robot',
        'port' => '5681',
        'charset' => 'utf8',
    ],
    'redis' => [
        'prefix' => '',
        "host" => "39.108.134.88",
        "port" => 6379,
        "auth" => "Mr.Zhou",
    ],
    'memcached' => [
        'prefix' => '',
        'host' => '',
        'port' => '',
    ],
    'application' => [
        'appDir' => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/Controllers/',
        'modelsDir' => APP_PATH . '/Models/',
        'migrationsDir' => APP_PATH . '/Migrations/',
        'viewsDir' => APP_PATH . '/Views/',
        'libraryDir' => APP_PATH . '/Library/',
        'cacheDir' => BASE_PATH . '/cache/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri' => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}"
    ],
    /** 默认控制器和方法 */
    'baseController' => '',
    'baseAction' => '',
]);
