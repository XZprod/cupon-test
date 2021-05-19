<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
 * @var \App\interfaces\ActionInterface $action
 */
require_once '../vendor/autoload.php';

$settings = require_once '../settings/settings.php';


$params = explode('?', $_SERVER['REQUEST_URI']);
//[$requestAction, $queryParams] = ;

$requestAction = $params[0];
$queryParams = $params[1] ?? '';

if ($queryParams) {
    $queryParamsPairs = explode('&', $queryParams);

    $queryParams = [];
    foreach ($queryParamsPairs as $pair) {
        [$key, $value] = explode('=', $pair);
        $queryParams[$key] = $value;
    }
}


$requestAction = mb_substr($requestAction, 1);

if (!$requestAction) {
    $requestAction = $settings['defaultAction'];
}

$actionClass = 'App\actions\\' . ucfirst(mb_strtolower($requestAction));

if (!class_exists($actionClass)) {
    die('Страница не найдена');
}

ob_start();
$action = new $actionClass();

$result = $action->run($queryParams);

//fixme может вынести отдельно в модели
if ($action->getResponseType() == 'json') {
    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} else {
    render($result);
}

ob_end_flush();
