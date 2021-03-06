<?php

/**
 * controller for the dating web app.
 * This file contains methods that are called in index.php
 * @author Heather Monatt
 *
 */

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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get the data from the post array
            $userFName = trim($_POST['firstName']);
            $userLName = trim($_POST['lastName']);
            $userAge = trim($_POST['age']);
            $userGender = $_POST['gender'];
            $userPhone = trim($_POST['phone']);

            //validate first name
            if (!$this->_validator->validFirstName($userFName)) {
                $this->_f3->set('errors["firstName"]', "First name cannot be blank and must be alphabetical");
            }
            //validate last name
            if (!$this->_validator->validLastName($userLName)) {
                $this->_f3->set('errors["lastName"]', "Last name cannot be blank and must be alphabetical");
            }
            //validate age
            if (!$this->_validator->validAge($userAge)) {
                $this->_f3->set('errors["age"]', "Age must be numeric and between 18 and 118");
            }
            //validate gender
            if(isset($userGender)) {
                if (!$this->_validator->validGender($userGender)) {
                    $this->_f3->set('errors["gender"]', "Go away Evildoer!");
                }
            }
            //validate phone number
            if (!$this->_validator->validPhone($userPhone)) {
                $this->_f3->set('errors["phone"]', "Phone number must be in this format: 555-867-5309");
            }
            //if there are no errors, redirect to /profile2
            if (empty($this->_f3->get('errors'))) {

                if (isset($_POST['premium'])) {
                    $_SESSION['member'] = new PremiumMember($userFName, $userLName, $userAge, $userGender, $userPhone);
                } else {
                    $_SESSION['member'] = new Member($userFName, $userLName, $userAge, $userGender, $userPhone);
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

        $view = new Template();
        echo $view->render('views/profile1.html');
    }

    function profile2()
    {
        //if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userEmail = trim($_POST['email']);
            $userState = $_POST['state'];
            $userSeeking = $_POST['seeking'];
            $userBio = $_POST['bio'];

            //email address validation
            if (!$this->_validator->validEmail($userEmail)) {
                $this->_f3->set('errors["email"]', "Invalid email format");
            }
            //validate state
            if (!$this->_validator->validState($userState)) {
                $this->_f3->set('errors["state"]', "Go away Evildoer!");
            }
            //validate seeking
            if(isset($userSeeking)) {
                if (!$this->_validator->validSeeking($userSeeking)) {
                    $this->_f3->set('errors["seeking"]', "Go away Evildoer!");
                }
            }
            //bio
            if (isset($userBio)) {
                $_SESSION['bio'] = $userBio;
            }
            //if there are no errors, redirect to /profile3
            if (empty($this->_f3->get('errors'))) {

                $_SESSION['member']->setEmail($userEmail);
                $_SESSION['member']->setState($userState);
                $_SESSION['member']->setSeeking($userSeeking);
                $_SESSION['member']->setBio($userBio);

                if ($_SESSION['member'] instanceof PremiumMember) {
                    $this->_f3->reroute('/profile3');
                } else {
                    $this->_f3->reroute('/summary');
                }

            }
        }

        $this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");
        $this->_f3->set('userState', isset($userState) ? $userState : "");
        $this->_f3->set('state', $this->_dataLayer->getStates());
        $this->_f3->set('userSeeking', isset($userSeeking) ? $userSeeking : "");
        $this->_f3->set('seekingRadios', $this->_dataLayer->getSeeking());
        $this->_f3->set('userBio', isset($userBio) ? $userBio : "");

        //display a view
        $view = new Template();
        echo $view->render('views/profile2.html');
    }

    function profile3()
    {
        $this->_f3->set('indoors', $this->_dataLayer->getIndoor());
        $this->_f3->set('outdoors', $this->_dataLayer->getOutdoor());

        //if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userIndoor = $_POST['indoor'];
            $userOutdoor = $_POST['outdoor'];

            //get data from profile 3 to session array
//                    if (isset($userIndoor)) {
//                        if(!$this->_validator->validIndoor($userIndoor)){
//                            $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
//                        }
//            if (isset($userIndoor)) {
//                if (!$this->_validator->validIndoor($userIndoor)) {
//                    $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
//                }
//            }

                        //data is valid -> add to session
                        if ($this->_dataLayer->getIndoor($userIndoor)) {
                            $_SESSION['indoor'] = implode(", ", $userIndoor);
                        }
                        //data is not valid -> We've been spoofed!
                        else {
                            $this->_f3->set('errors["indoor"]', "Go away, evildoer!");
                        }

//            //get data from profile 3 to session array
//            if (isset($userOutdoor)) {
//                if (!$this->_validator->validOutdoor($userOutdoor)) {
//                    $this->_f3->set('errors["outdoor"]', "Go away, evildoer!");
//                }
//            }

            //data is valid -> add to session
                        if ($this->_dataLayer->getOutdoor($userOutdoor)) {
                            $_SESSION['outdoor'] = implode(", ", $userOutdoor);
                        }
                        //data is not valid -> We've been spoofed!
                        else {
                            $this->_f3->set('errors["outdoor"]', "Go away, evildoer!");
                        }

            //if there are no errors, redirect user to summary page
            if (empty($this->_f3->get('errors'))) {

                //$_SESSION['member']->setIndoorInterests($userIndoor);
                //$_SESSION['member']->setOutdoorInterests($userOutdoor);

                if (isset($userIndoor)) {
                    $_SESSION['member']->setIndoorInterests($userIndoor);
                } else {
                    $_SESSION['member']->setIndoorInterests(array('No indoor activities selected'));
                }
                if (isset($userOutdoor)) {
                    $_SESSION['member']->setOutdoorInterests($userOutdoor);
                } else {
                    $_SESSION['member']->setOutdoorInterests(array('No outdoor activities selected'));
                }


                //$_SESSION['membership']->setIndoorInterests($userIndoor);
                //$_SESSION['membership']->setOutdoorInterests($userOutdoor);

                $this->_f3->reroute('/summary');
            }
        }

            //$this->_f3->set('indoors', getIndoor());

            $this->_f3->set('indoor', isset($userIndoor) ? $userIndoor : []);
            $this->_f3->set('outdoor', isset($userOutdoor) ? $userOutdoor : []);

            //$this->_f3->set('outdoors', getOutdoor());

            //display a view
            $view = new Template();
            echo $view->render('views/profile3.html');
        }

        function summary()
        {
            $view = new Template();
            echo $view->render('views/summary.html');

            session_destroy();

        }

}
