<?php
require_once("./controller/transaction_controller.php");

$requestType = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : "GET";
$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$controllerAndMethod = explode('/', $url);

$controller = $controllerAndMethod[1];
$method = $controllerAndMethod[2];
$params = array_slice($controllerAndMethod, 3);

if (class_exists($controller)) {
    $calledController = new $controller();

    $calledController->{'action' . $requestType . $method}(...$params);
}

?>
