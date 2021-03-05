<?php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function profile()
    {
        //if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get the data from the post array
            $userFName = trim($_POST['firstName']);
            $userLName = trim($_POST['lastName']);
            $userAge = trim($_POST['age']);
            $userPhone = trim($_POST['phone']);
            $userGender = $_POST['genderRadio'];

            //if the data is valid --> store in session
            if (validFirstName($userFName)) {
                $_SESSION['firstName'] = $userFName;
            } //data is not valid -> set an error in F3 hive
            else {
                $this->_f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
            }
            //if the data is valid --> store in session
            if (validLastName($userLName)) {
                $_SESSION['lastName'] = $userLName;
            } //data is not valid -> set an error in F3 hive
            else {
                $this->_f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
            }
            //if the data is valid --> store in session
            if (validAge($userAge)) {
                $_SESSION['age'] = $userAge;
            } //data is not valid -> set an error in F3 hive
            else {
                $this->_f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
            }
            //if the data is valid --> store in session
            if (validPhone($userPhone)) {
                $_SESSION['phone'] = $userPhone;
            } //data is not valid -> set an error in F3 hive
            else {
                $this->_f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
            }

            //add data from profile1 to session array
            //gender
            if (validGender($userGender)) {
                $_SESSION['genderRadio'] = $userGender;
            } else {
                $this->_f3->set('errors[genderRadio]', "Go away Evildoer!");
            }

            //if there are no errors, redirect to /profile2
            if (empty($this->_f3->get('errors'))) {

                if(isset($_POST['membership'])){
                    $_SESSION['membership'] = new PremiumMember($userFName, $userLName, $userAge, $userGender, $userPhone);
                } else {
                    $_SESSION['membership'] = new Member($userFName, $userLName, $userAge, $userGender, $userPhone);
                }

                $this->_f3->reroute('/profile2');
            }
        }

        $this->_f3->set('userFName', isset($userFName) ? $userFName : "");
        $this->_f3->set('userLName', isset($userLName) ? $userLName : "");
        $this->_f3->set('userAge', isset($userAge) ? $userAge : "");
        $this->_f3->set('userPhone', isset($userPhone) ? $userPhone : "");
        $this->_f3->set('genderRadios', getGender());
        $this->_f3->set('selectedGender', $_POST['genderRadio']);

        //echo "Profile 1";
        $view = new Template();
        echo $view->render('views/profile1.html');
    }

    function profile2()
    {
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
                    $this->_f3->set('errors["email"]', "Invalid email format");
                }
                //add data from profile2 to session array
                //state
                if(isset($userState)){
                    $_SESSION['state'] = $userState;
                }

                if (validState($userState)) {
                    $_SESSION['state'] = $userState;
                } else {
                    $this->_f3->set('errors["state"]', "Go away Evildoer!");
                }


                //add data from profile1 to session array
                //gender
                if (validSeeking($userSeeking)) {
                    $_SESSION['seekingRadio'] = $userSeeking;
                } else {
                    $this->_f3->set('errors["seekingRadio"]', "Go away Evildoer!");
                }


                //get data from profile 3 to session array
                if (isset($userBio)) {
                    $_SESSION['bio'] = $userBio;

                }
                //if there are no errors, redirect to /profile3
                if(empty($this->_f3->get('errors'))) {

                    $_SESSION['membership']->setEmail($userEmail);
                    $_SESSION['membership']->setState($userState);
                    $_SESSION['membership']->setSeeking($userSeeking);
                    $_SESSION['membership']->setBio($userBio);

                    if($_SESSION['membership'] instanceof PremiumMember){
                        $this->_f3->reroute('/profile3');
                    } else {
                        $this->_f3->reroute('/summary');
                    }

                    //$f3->reroute('/profile3');
                }
            }

            $this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");

            $this->_f3->set('states', getState());
            $this->_f3->set('selectedState', $_POST['state']);
            //$f3->set('userState', isset($userState) ? $userState : "");

            $this->_f3->set('seekingRadios', getSeeking());
            $this->_f3->set('selectedSeeking', $_POST['seekingRadio']);

            $this->_f3->set('userBio', isset($userBio) ? $userBio : "");

            //display a view
            //echo "Profile 2 Route";
            $view = new Template();
            echo $view->render('views/profile2.html');

        }

        function profile3()
        {
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
                            $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
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
                            $this->_f3->set('errors["outdoor"]', "Go away, evildoer!");
                        }
                    }
                    //if there are no errors, redirect user to summary page
                    if(empty($this->_f3->get('errors'))){

                        $_SESSION['membership']->setIndoorInterests($userIndoor);
                        $_SESSION['membership']->setOutdoorInterests($userOutdoor);

                        $this->_f3->reroute('/summary');
                    }
                }

                $this->_f3->set('indoors', getIndoor());
                $this->_f3->set('outdoors', getOutdoor());

                //display a view
                //echo "Profile 3 Route";
                $view = new Template();
                echo $view->render('views/profile3.html');
        }

        function summary()
        {
                $view = new Template();
                echo $view->render('views/summary.html');

                //Clear the SESSION array
                session_destroy();

        }
}
