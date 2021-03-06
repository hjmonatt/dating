<?php

//Heather Monatt
//January 27th, 2021
//February 10th, 2021 - updated
//March 4th, 2021 - updated
//This is my index.php, the controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

$controller = new Controller($f3);

//Start a session
session_start();

//Define a default route (home page)
$f3->route('GET /', function() use($controller) {
    $controller->home();
});

//Define a personal profile route
$f3->route('GET|POST /profile', function() use ($controller) {
    $controller->profile();
});

//Define a profile2 route
$f3->route('GET|POST /profile2', function() use ($controller){
    $controller->profile2();
});

//Define a profile3 route
$f3->route('GET|POST /profile3', function() use ($controller) {
    $controller->profile3();
});

//Define a summary route
$f3->route('GET|POST /summary', function() use ($controller) {
    $controller->summary();
});

//Run fat free
$f3->run();