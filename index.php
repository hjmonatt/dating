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
        $fName = trim($_POST['firstName']);
        $lName = trim($_POST['lastName']);
        $age = trim($_POST['age']);
        $phone = trim($_POST['phone']);
        $gender = $_POST['genderRadios'];

        //if the data is valid --> store in session
        if(validFirstName($fName)) {
            $_SESSION['firstName'] = $fName;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
        }
        //if the data is valid --> store in session
        if(validLastName($lName)){
            $_SESSION['lastName'] = $lName;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
        }
        //if the data is valid --> store in session
        if(validAge($age)) {
            $_SESSION['age'] = $age;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
        }
        //if the data is valid --> store in session
        if(validPhone($phone)) {
            $_SESSION['phone'] = $phone;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
        }

        //add data from profile1 to session array
        //gender
        if(isset($gender)){
            $_SESSION['genderRadios'] = $gender;
        }

        //if there are no errors, redirect to /profile2
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile2');
        }
    }

    $f3->set('fname', isset($fName) ? $fName : "");
    $f3->set('lname', isset($lName) ? $lName : "");
    $f3->set('age', isset($age) ? $age : "");
    $f3->set('phone', isset($phone) ? $phone : "");
    $f3->set('gender', getGender());

    //echo "Profile 1";
    $view = new Template();
    echo $view->render('views/profile1.html');
});

//Define a profile2 route
$f3->route('GET|POST /profile2', function($f3) {

    //var_dump($_POST);

    //if the form has been submitted
    if ($_SERVER['REQUEST_METHOD']=='POST') {

        $email = trim($_POST['email']);
        $state = $_POST['state'];
        $seeking = $_POST['seekingRadios'];
        $bio = trim($_POST['bio']);

        //email address validation
        if (validEmail($email)) {
            $_SESSION['email'] = $email;
        } else {
            $f3->set('errors["email"]', "Invalid email format");
        }
        //add data from profile2 to session array
        //state
        if(isset($state)){
            $_SESSION['state'] = $state;
        }
        //seeking option
        if(isset($seeking)){
            $_SESSION['seekingRadios'] = $seeking;
        }
        //bio
        if(isset($bio)){
            $_SESSION['bio'] = $bio;
        }
        //if there are no errors, redirect to /profile3
        if(empty($f3->get('errors'))) {
            $f3->reroute('/profile3');
        }
    }

    $f3->set('email', isset($email) ? $email : "");
    $f3->set('state', isset($state) ? $state : "");
    $f3->set('seeking', isset($seeking) ? $seeking : "");
    $f3->set('bio', isset($bio) ? $bio : "");

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