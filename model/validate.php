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