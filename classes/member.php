<?php

/**
 * Member class
 * takes the user's info and stores it as an object
 * @author Heather Monatt
 */

class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Constructor - constructs a Member object
     * @param $fname - String of member's first name
     * @param $lname - String of member's last name
     * @param $age - int of member's age
     * @param $gender - String of member's gender
     * @param $phone - String of member's phone number
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;

    }

    /**
     * @return String - member's first name
     */
    public function getFName()
    {
        return $this->_fname;
    }

    /**
     * @param String $fname
     */
    public function setFName($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return String - member's last name
     */
    public function getLName()
    {
        return $this->_lname;
    }

    /**
     * @param String $lname
     */
    public function setLName($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return int - member's age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return String - member's gender
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param String $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return String - member's phone number
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param String $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return String - member's email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return String - member's state location
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param String $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * @return String - member's seeking gender
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * @param String $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * @return String - member's bio
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param String $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }

}
