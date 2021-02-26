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
require_once('model/data-layer.php');
require_once('model/validate.php');

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

        //get the data from the post array
        $userFName = trim($_POST['firstName']);
        $userLName = trim($_POST['lastName']);
        $userAge = trim($_POST['age']);
        $userPhone = trim($_POST['phone']);
        $userGender = $_POST['genderRadio'];

        //if the data is valid --> store in session
        if(validFirstName($userFName)) {
            $_SESSION['firstName'] = $userFName;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
        }
        //if the data is valid --> store in session
        if(validLastName($userLName)){
            $_SESSION['lastName'] = $userLName;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
        }
        //if the data is valid --> store in session
        if(validAge($userAge)) {
            $_SESSION['age'] = $userAge;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
        }
        //if the data is valid --> store in session
        if(validPhone($userPhone)) {
            $_SESSION['phone'] = $userPhone;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
        }

        //add data from profile1 to session array
        //gender
        if(validGender($userGender)){
            $_SESSION['genderRadio'] = $userGender;
        }
        else {
            $f3->set('errors[genderRadio]', "Go away Evildoer!");
        }

        //if there are no errors, redirect to /profile2
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile2');
        }
    }

    $f3->set('userFName', isset($userFName) ? $userFName : "");
    $f3->set('userLName', isset($userLName) ? $userLName : "");
    $f3->set('userAge', isset($userAge) ? $userAge : "");
    $f3->set('userPhone', isset($userPhone) ? $userPhone : "");
    $f3->set('genderRadios', getGender());
    $f3->set('selectedGender', $_POST['genderRadio']);

    //echo "Profile 1";
    $view = new Template();
    echo $view->render('views/profile1.html');
});

//Define a profile2 route
$f3->route('GET|POST /profile2', function($f3) {

    //var_dump($_POST);

    //if the form has been submitted
    if ($_SERVER['REQUEST_METHOD']=='POST') {

        $userEmail = trim($_POST['email']);
        $userState = $_POST['state'];
        $userSeeking = $_POST['seekingRadio'];
        $userBio = $_POST['bio'];

        //email address validation
        if (validEmail($userEmail)) {
            $_SESSION['email'] = $userEmail;
        } else {
            $f3->set('errors["email"]', "Invalid email format");
        }
        //add data from profile2 to session array
        //state
        if(isset($userState)){
            $_SESSION['state'] = $userState;
        }

        if (validState($userState)) {
            $_SESSION['state'] = $userState;
        } else {
            $f3->set('errors["state"]', "Go away Evildoer!");
        }


        //add data from profile1 to session array
        //gender
        if (validSeeking($userSeeking)) {
            $_SESSION['seekingRadio'] = $userSeeking;
        } else {
            $f3->set('errors["seekingRadio"]', "Go away Evildoer!");
        }


        //get data from profile 3 to session array
        if (isset($userBio)) {
            $_SESSION['bio'] = $userBio;

        }
        //if there are no errors, redirect to /profile3
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile3');
        }
    }

    $f3->set('userEmail', isset($userEmail) ? $userEmail : "");

    $f3->set('states', getState());
    $f3->set('selectedState', $_POST['state']);
    //$f3->set('userState', isset($userState) ? $userState : "");

    $f3->set('seekingRadios', getSeeking());
    $f3->set('selectedSeeking', $_POST['seekingRadio']);

    $f3->set('userBio', isset($userBio) ? $userBio : "");

    //display a view
    //echo "Profile 2 Route";
    $view = new Template();
    echo $view->render('views/profile2.html');

});

//Define a profile3 route
$f3->route('GET|POST /profile3', function($f3) {

    //if the form has been submitted
    if($_SERVER['REQUEST_METHOD']=='POST') {

        //get data from profile 3 to session array
        if (isset($_POST['indoor'])) {
            $userIndoor = $_POST['indoor'];

            //data is valid -> add to session
            if (validIndoor($userIndoor)) {
                $_SESSION['indoor'] = implode(", ", $userIndoor);
            }
            //data is not valid -> We've been spoofed!
            else {
                $f3->set('errors["indoor"]', "Go away, evildoer!");
            }
        }
        //get data from profile 3 to session array
        if (isset($_POST['outdoor'])) {
            $userOutdoor = $_POST['outdoor'];

            //data is valid -> add to session
            if (validOutdoor($userOutdoor)) {
                $_SESSION['outdoor'] = implode(", ", $userOutdoor);
            }
            //data is not valid -> We've been spoofed!
            else {
                $f3->set('errors["outdoor"]', "Go away, evildoer!");
            }
        }
        //if there are no errors, redirect user to summary page
        if(empty($f3->get('errors'))){
            $f3->reroute('/summary');
        }
    }

    $f3->set('indoors', getIndoor());
    $f3->set('outdoors', getOutdoor());

    //display a view
    //echo "Profile 3 Route";
    $view = new Template();
    echo $view->render('views/profile3.html');

});

//Define a summary route
$f3->route('GET /summary', function() {

    //echo "<p>POST:<p>";
    //var_dump($_POST);           //post array only contains the most updated data

    //echo "<p>SESSION:<p>";
    //var_dump($_SESSION);        //session array most secure array for data

    //display a view
    //echo "Summary Route";
    $view = new Template();
    echo $view->render('views/summary.html');

    //Clear the SESSION array
    session_destroy();

});

//Run fat free
$f3->run();