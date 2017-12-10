<?php


$router = $di->getRouter();

$router->setDefaults([
    "controller" => $config->baseController,
    "action" => $config->baseAction,
    "namespace" => "App\\Controllers\\Forum"
]);

$modules = [
    'base.api' => 'BaseApi',
    'admin.api' => 'Admin\\Api',
    'admin.web' => 'Admin\\Web',
    'news' => 'News',
    'forum' => 'Forum',
    'auth' => 'Auth',
    'user' => 'User',
];


foreach ($modules as $key => $name) {
    $router->add('/' . $key . '/:controller/:action/:params', [
        'namespace' => "App\\Controllers" . ($name ? "\\$name" : ""),
        'controller' => 1,
        'action' => 2,
        'params' => 3
    ]);
}

$router->handle();
