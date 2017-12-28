<?php

return new \Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host' => '5775d04228bfe.sh.cdb.myqcloud.com',
        'username' => 'cdb_outerroot',
        'password' => 'huoniaojungege@',
        'dbname' => 'phalcon-forum',
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
    'version' => '1.0',

    /**
     * if true, then we print a new line at the end of each execution
     *
     * If we dont print a new line,
     * then the next command prompt will be placed directly on the left of the output
     * and it is less readable.
     *
     * You can disable this behaviour if the output of your application needs to don't have a new line at end
     */
    'printNewLine' => true
]);
