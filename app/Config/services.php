<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Logger\Adapter\File as FileLogAdapter;
use Phalcon\Logger;
use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Memcache as BackendMemcache;
use Phalcon\Cache\Backend\Redis as BackendRedis;

/**
 * 注册全局配置
 */
$di->setShared('config', function () {
    return include APP_PATH . "/Config/config.php";
});

/**
 * 注册公共全局配置
 */
$di->setShared('commonConfig', function () {
    return include APP_PATH . "/Config/common.php";
});

/**
 * 注册公共全局配置
 */
$di->setShared('lastQuery', function () {
    return new stdClass();
});

/**
 * 注册全局日志服务
 */
$di->setShared('log', function () {
    $path = BASE_PATH . '/log/';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
    return new FileLogAdapter($path . date('Y-m-d') . ".log");
});


/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => false,
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class
    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname,
        'port' => $config->database->port,
        'charset' => $config->database->charset
    ];
    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }
    /** 监听sql执行日志 */
    $logger = $this->getLog();
    $lastQuery = $this->getLastQuery();
    $eventsManager = new \Phalcon\Events\Manager();
    $eventsManager->attach(
        "db:afterQuery",
        function ($event, $connection) use ($logger, $lastQuery) {
            $lastQuery->sql = $connection->getSQLStatement();
            $logger->log(
                $connection->getSQLStatement(),
                Logger::INFO
            );
        }
    );
    $connection = new $class($params);
    $connection->setEventsManager($eventsManager);
    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

// 设置模型缓存服务
$di->set("modelsCache", function () {
    $frontCache = new FrontendData(["lifetime" => 86400,]);
    $cache = new BackendRedis($frontCache, [
        "host" => $this->getConfig()->redis->host,
        "port" => $this->getConfig()->redis->port,
        "auth" => $this->getConfig()->redis->auth,
        "prefix" => $this->getConfig()->redis->prefix
    ]);
    return $cache;
}
);

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});
