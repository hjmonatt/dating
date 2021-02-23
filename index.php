<?php

//Heather Monatt
//January 27th, 2021
//February 10th, 2021 - updated
//This is my CONTROLLER


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');
require_once ('model/validate.php');

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
$f3->route('GET|POST /profile', function($f3) {

    //if the form has been submitted
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        //first name validation
        if(validFirstName($_POST['firstName'])) {
            $_SESSION['firstName'] = $_POST['firstName'];
        }
        else {
            $f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
        }
        //last name validation
        if(validLastName($_POST['lastName'])) {
            $_SESSION['lastName'] = $_POST['lastName'];
        }
        else {
            $f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
        }
        //age validation
        if(validAge($_POST['age'])) {
            $_SESSION['age'] = $_POST['age'];
        }
        else {
            $f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
        }
        //phone number validation
        if(validPhone($_POST['phone'])) {
            $_SESSION['phone'] = $_POST['phone'];
        }
        else {
            $f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
        }

        //add data from profile1 to session array
        //gender
        if(isset($_POST['genderRadios'])){
            $_SESSION['genderRadios'] = $_POST['genderRadios'];
        }

        //if there are no errors, redirect to /profile2
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile2');
        }
    }
    //echo "Profile 1";
    $view = new Template();
    echo $view->render('views/profile1.html');
});

//Define a profile2 route
$f3->route('GET|POST /profile2', function($f3) {

    //var_dump($_POST);

    //add data from profile form to session array
//    if(isset($_POST['firstName'])){
//        $_SESSION['firstName'] = $_POST['firstName'];
//    }
//    if(isset($_POST['lastName'])){
//        $_SESSION['lastName'] = $_POST['lastName'];
//    }
//    if(isset($_POST['age'])){
//        $_SESSION['age'] = $_POST['age'];
//    }

    //if the form has been submitted
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        //email address validation
        if (validEmail($_POST['email'])) {
            $_SESSION['email'] = $_POST['email'];
        } else {
            $f3->set('errors["email"]', "Invalid email format");
        }

        //add data from profile2 to session array
        //state
        if(isset($_POST['state'])){
            $_SESSION['state'] = $_POST['state'];
        }
        //seeking option
        if(isset($_POST['seekingRadios'])){
            $_SESSION['seekingRadios'] = $_POST['seekingRadios'];
        }
        //bio
        if(isset($_POST['bio'])){
            $_SESSION['bio'] = $_POST['bio'];
        }


        //if there are no errors, redirect to /profile3
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile3');
        }
    }


//    if(isset($_POST['phone'])){
//        $_SESSION['phone'] = $_POST['phone'];
//    }


    //display a view
    //echo "Profile 2 Route";
    $view = new Template();
    echo $view->render('views/profile2.html');

});

//Define a profile3 route
$f3->route('GET|POST /profile3', function() {

//    //add data from profile form 2 to session array
//    if(isset($_POST['email'])){
//        $_SESSION['email'] = $_POST['email'];
//    }


    //display a view
    //echo "Profile 3 Route";
    $view = new Template();
    echo $view->render('views/profile3.html');

});

//Define a summary route
$f3->route('POST /summary', function() {

    //echo "<p>POST:<p>";
    //var_dump($_POST);           //post array only contains the most updated data

    //echo "<p>SESSION:<p>";
    //var_dump($_SESSION);        //session array most secure array for data

    //add data from profile form 3 to session array
    if(isset($_POST['interests'])){
        $_SESSION['interests'] = implode(", ", $_POST['interests']);
    }


    //echo "Summary Route";
    $view = new Template();
    echo $view->render('views/summary.html');

    //Clear the SESSION array
    session_destroy();

});


//Run fat free
$f3->run();