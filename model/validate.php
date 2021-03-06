<?php

/**
 * Heather Monatt
 * February 22nd, 2021
 * model/validate.php
 * Contains validation functions for Dating Website
 */

class Validate
{
    private $_dataLayer;

    function __construct()
    {
        $this->_dataLayer = new DataLayer();
    }
    /**
     * validFirstName() checks to see that a string is all alphabetic
     */
    function validFirstName($firstName)
    {
        return !empty(trim($firstName)) && ctype_alpha($firstName);
    }

    /**
     * validLastName() checks to see that a string is all alphabetic
     */
    function validLastName($lastName)
    {
        return !empty(trim($lastName)) && ctype_alpha($lastName);
    }

    /**
     * validAge() checks to see that an age is numeric and between 18 and 118
     */
    function validAge($age)
    {
        return !empty(is_numeric($age)) && $age >= 18 && $age <= 118;
    }

    /**
     * validGender() checks if gender is valid
     */
    function validGender($gender)
    {
        return in_array($gender, $this->_dataLayer->getGender());
    }


    /**
     * validPhone() checks to see that a phone number is valid
     */
    function validPhone($phone)
    {
        return !empty(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone));
    }

    /**
     * validEmail() checks to see that an email address is valid
     */
    function validEmail($email)
    {
        return !empty(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * validState() checks each selected state against a list of valid options
     */
    function validState($state)
    {
        return in_array($state, $this->_dataLayer->getStates());
    }

    /**
     * validIndoor() checks each selected indoor interest against a list of valid options
     */
    function validIndoor($indoor)
    {
        $valid = false;
        foreach ($indoor as $selected) {
            if (in_array($selected, $this->_dataLayer->getIndoor())) {
                $valid = true;
            }else {
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * validIndoor() checks each selected indoor interest against a list of valid options
     */
    function validOutdoor($outdoor)
    {
        $valid = false;
        foreach ($outdoor as $selected) {
            if (in_array($selected, $this->_dataLayer->getOutdoor())) {
                $valid = true;
            }else {
                $valid = false;
            }
        }
        return $valid;

    }

    /**
     * validSeeking() checks selected seeking gender against a list of valid options
     */
    function validSeeking($seeking)
    {
        return in_array($seeking, $this->_dataLayer->getSeeking());
    }


}

