<?php

/**
 * Heather Monatt
 * February 22nd, 2021
 * model/validate.php
 * Contains validation function for Dating Website
 */


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
     * validIndoor() checks each selected indoor interest against a list of valid options
     */
    function validIndoor($selectedIndoor)
    {
        $validIndoorActs = getIndoor();
        foreach ($selectedIndoor as $selected) {
            if (!in_array($selected, $validIndoorActs)) {
                return false;
            }
        }
        return true;
    }

    /**
     * validIndoor() checks each selected indoor interest against a list of valid options
     */
    function validOutdoor($selectedOutdoor)
    {
        $validOutdoorActs = getOutdoor();
        foreach ($selectedOutdoor as $selected) {
            if (!in_array($selected, $validOutdoorActs)) {
                return false;
            }
        }
        return true;

    }

    /**
     * validSeeking() checks selected seeking gender against a list of valid options
     */
    function validSeeking($selectedSeeking)
    {
        $validUserSeeking = getSeeking();
        return in_array($selectedSeeking, $validUserSeeking);
    }

    /**
     * validGender() checks each selected gender against a list of valid options
     */
    function validGender($selectedGender)
    {
        $validUserGender = getGender();
        return in_array($selectedGender, $validUserGender);
    }

    /**
     * validState() checks each selected state against a list of valid options
     */
    function validState($selectedState)
    {
        $validUserState = getState();
        return in_array($selectedState, $validUserState);
    }

