<?php
session_start();
require_once '../Database.php';
header("Access-Control-Allow-Origin: *");

$uriPathInfo = $_SERVER['PATH_INFO'];

$path = explode('/', $uriPathInfo);
$requestClass = $path[1];

$requestClass = preg_replace('#[^0-9a-zA-Z]#', '', $requestClass);
$className = ucfirst(strtolower($requestClass));

$classFile = '../'.$className.'.php';
require_once $classFile;

$pathId = isset($path[2]) ? $path[2] : null;

include_once $className . '.php';

header('Content-Type: application/json');

echo json_encode($response);