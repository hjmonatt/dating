<?php

//Heather Monatt
//January 27th, 2021
//This is my CONTROLLER


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//Define a default route (home page)
$f3->route('GET /', function() {
    //echo "Boo'd Up!";
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a personal profile route
$f3->route('GET /profile', function() {

    echo "Profile 1";
    //$view = new Template();
    //echo $view->render('views/profile1.html');
});


//Run fat free
$f3->run();