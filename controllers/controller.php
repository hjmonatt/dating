<?php

class Controller
{
    private $_f3;
    private $_validator;
    private $_dataLayer;

    function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_validator = new Validate();
        $this->_dataLayer = new DataLayer();
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function profile()
    {
        $this->_f3->set('genderRadios', $this->_dataLayer->getGender());
        //if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get the data from the post array
            $userFName = trim($_POST['firstName']);
            $userLName = trim($_POST['lastName']);
            $userAge = trim($_POST['age']);
            $userPhone = trim($_POST['phone']);
            $userGender = $_POST['genderRadio'];

            //validate first name
            if(!$this->_validator->validFirstName($userFName)){
                $this->_f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
            }
//            if (validFirstName($userFName)) {
//                $_SESSION['firstName'] = $userFName;
//            } //data is not valid -> set an error in F3 hive
//            else {
//                $this->_f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
//            }
            //validate last name
            if(!$this->_validator->validLastName($userLName)) {
                $this->_f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
            }
//            if (validLastName($userLName)) {
//                $_SESSION['lastName'] = $userLName;
//            } //data is not valid -> set an error in F3 hive
//            else {
//                $this->_f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
//            }
            //validate age
            if(!$this->_validator->validAge($userAge)){
                $this->_f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
            }
//            if (validAge($userAge)) {
//                $_SESSION['age'] = $userAge;
//            } //data is not valid -> set an error in F3 hive
//            else {
//                $this->_f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
//            }
            //validate phone number
            if(!$this->_validator->validPhone($userPhone)){
                $this->_f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
            }
//            if (validPhone($userPhone)) {
//                $_SESSION['phone'] = $userPhone;
//            } //data is not valid -> set an error in F3 hive
//            else {
//                $this->_f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
//            }

            //add data from profile1 to session array
            //gender
            //validate gender
            if(isset($userGender)){
                if(!$this->_validator->validGender($userGender)){
                    $this->_f3->set('errors[genderRadio]', "Go away Evildoer!");
                }
            }

//            if (validGender($userGender)) {
//                $_SESSION['genderRadio'] = $userGender;
//            } else {
//                $this->_f3->set('errors[genderRadio]', "Go away Evildoer!");
//            }

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
        $this->_f3->set('genderRadios', $this->_dataLayer->getGender());
        $this->_f3->set('userGender', isset($userGender) ? $userGender : "");
        //$this->_f3->set('selectedGender', $_POST['genderRadio']);

        //echo "Profile 1";
        $view = new Template();
        echo $view->render('views/profile1.html');
    }

    function profile2()
    {
        $this->_f3->set('genderRadio', $this->_dataLayer->getGender());
        $this->_f3->set('state', $this->_dataLayer->getState());

            //if the form has been submitted
            if ($_SERVER['REQUEST_METHOD']=='POST') {

                $userEmail = trim($_POST['email']);
                $userState = $_POST['state'];
                $userSeeking = $_POST['seekingRadio'];
                $userBio = $_POST['bio'];

                //email address validation
                if(!$this->_validator->validEmail($userEmail)){
                    $this->_f3->set('errors["email"]', "Invalid email format");
                }
//                if (validEmail($userEmail)) {
//                    $_SESSION['email'] = $userEmail;
//                } else {
//                    $this->_f3->set('errors["email"]', "Invalid email format");
//                }
                //add data from profile2 to session array

                //validate state
                    if($this->_validator->validState($userState)){
                        $this->_f3->set('errors["state"]', "Go away Evildoer!");
                    }
                    //$_SESSION['state'] = $userState;


//                if (validState($userState)) {
//                    $_SESSION['state'] = $userState;
//                } else {
//                    $this->_f3->set('errors["state"]', "Go away Evildoer!");
//                }


                //add data from profile1 to session array
                //validate gender
                if(isset($userSeeking)){
                    if($this->_validator->validSeeking($userSeeking)){
                        $this->_f3->set('errors["seekingRadio"]', "Go away Evildoer!");
                    }
                }

//                if (validSeeking($userSeeking)) {
//                    $_SESSION['seekingRadio'] = $userSeeking;
//                } else {
//                    $this->_f3->set('errors["seekingRadio"]', "Go away Evildoer!");
//                }


//                //get data from profile 3 to session array
//                if (isset($userBio)) {
//                    $_SESSION['bio'] = $userBio;
//
//                }
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

            //$this->_f3->set('states', getState());
            $this->_f3->set('userState', isset($userState) ? $userState : "");
            $this->_f3->set('selectedState', $this->_dataLayer->getSeeking());
            //$this->_f3->set('selectedState', $_POST['state']);
            //$f3->set('userState', isset($userState) ? $userState : "");

            //$this->_f3->set('seekingRadios', getSeeking());
            $this->_f3->set('userSeeking', isset($userSeeking) ? $userSeeking : "");
            $this->_f3->set('seekingRadios', $this->_dataLayer->getSeeking());
            //$this->_f3->set('userSeeking', isset($userGender) ? $userGender : "");
            //$this->_f3->set('selectedSeeking', $_POST['seekingRadio']);

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
                    $userIndoor = $_POST['indoor'];
                    $userOutdoor = $_POST['outdoor'];

                    //get data from profile 3 to session array
                    if (isset($userIndoor)) {
                        if(!$this->_validator->validIndoor($userIndoor)){
                            $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
                        }

//                        //data is valid -> add to session
//                        if (validIndoor($userIndoor)) {
//                            $_SESSION['indoor'] = implode(", ", $userIndoor);
//                        }
//                        //data is not valid -> We've been spoofed!
//                        else {
//                            $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
//                        }
                    }
                    //get data from profile 3 to session array
                    if (isset($userOutdoor)) {
                        if(!$this->_validator->validOutdoor($userOutdoor)){
                            $this->_f3->set('errors["outdoor"]', "Go away, evildoer!");
                        }

                        //data is valid -> add to session
//                        if (validOutdoor($userOutdoor)) {
//                            $_SESSION['outdoor'] = implode(", ", $userOutdoor);
//                        }
//                        //data is not valid -> We've been spoofed!
//                        else {
//                            $this->_f3->set('errors["outdoor"]', "Go away, evildoer!");
//                        }
                    }
                    //if there are no errors, redirect user to summary page
                    if(empty($this->_f3->get('errors'))){

                        if(isset($userIndoor)){
                            $_SESSION['membership']->setIndoorInterests($userIndoor);
                        }
                        if(isset($userOutdoor)){
                            $_SESSION['membership']->setOutdoorInterests($userOutdoor);
                        }


                        //$_SESSION['membership']->setIndoorInterests($userIndoor);
                        //$_SESSION['membership']->setOutdoorInterests($userOutdoor);

                        $this->_f3->reroute('/summary');
                    }
                }

                //$this->_f3->set('indoors', getIndoor());
                $this->_f3->set('indoors', isset($userIndoor) ? $userIndoor : []);
                $this->_f3->set('indoors', $this->_dataLayer->getIndoor());
                $this->_f3->set('outdoors', isset($userOutdoor) ? $userOutdoor : []);
                $this->_f3->set('outdoors', $this->_dataLayer->getOutdoor());
                //$this->_f3->set('outdoors', getOutdoor());

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
