<?php

use Controller\HomeController;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/vendor/autoload.php';

ini_set('max_execution_time', 300000000);
microtime(true);

$request = Request::createFromGlobals();
$controller =  new HomeController();
$response = $controller->handleRequest($request);
$response->send();

