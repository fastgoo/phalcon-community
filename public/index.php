<?php
use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
/*(new \Phalcon\Debug())->listen();*/
try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/Config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Handle routes
     */
    include APP_PATH . '/Config/router.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /**
     * 引入composer自动加载
     */
    include BASE_PATH . '/vendor/autoload.php';

    echo str_replace(["\n", "\r", "\t"], '', $application->handle()->getContent());

} catch (\Exception $e) {

    if (strpos($e->getMessage(), "not found") !== false || strpos($e->getMessage(), "handler class cannot be loaded") !== false) {
        $di = \Phalcon\Di::getDefault();

        if ($di->get("request")->isAjax() || !$di->get("request")->isGet()) {
            output_data(-404, '接口飞到火星去了');
        }
        $di->get("response")->setStatusCode(404, 'Not Found');
        $di->get('view')->render("common", "error404");
        exit;
    }
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
