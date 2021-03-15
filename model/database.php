<?php
/*
 * Heather Monatt
 * March 14th, 2021
 * model/database.php
 * database layer
 *
 */
class Database
{
    // fields
    private $_dbh;

    /**
     * Database constructor.
     * @param $dbh - dbh object
     */
    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /**
     * insertMember() method - adds a Member/PremiumMember object to database
     * @param $member - Member/PremiumMember object
     */
    function insertMember($member)
    {
        //define the query
        $sql = "INSERT INTO member (fname, lname, age, phone, email, state, gender, seeking, bio, premium, interests, image)
        VALUES (:fname, :lname, :age, :phone, :email, :state, :gender, :seeking, :bio, :premium, :interests, :image";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //assign regular members variables
        $premium = false;
        $interests = '';
        $imagePath = '';

        //PremiumMember variables
        if ($member instanceof PremiumMember) {
            $premium = true;
            $interests = $member->getIndoorInterests();
            $interests .=', ' . $member->getOutdoorInterests();
        }

        //bind the parameters
        $fname = $_SESSION['member']->getFName();
        $lname = $_SESSION['member']->getLName();
        $age = $_SESSION['member']->getAge();
        $gender = $_SESSION['member']->getGender();
        $phone = $_SESSION['member']->getPhone();
        $email = $_SESSION['member']->getEmail();
        $state = $_SESSION['member']->getState();
        $seeking = $_SESSION['member']->getSeeking();
        $bio = $_SESSION['member']->getBio();

        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_INT);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_INT);
        $statement->bindParam(':interests', $interests, PDO::PARAM_STR);
        $statement->bindParam(':image', $imagePath, PDO::PARAM_STR);

        //execute
        $statement->execute();
    }

    /**
     * getMembers() method - retreives Member/PremiumMember objects from database
     * @param $member - Member/PremiumMember object
     */
    function getMembers()
    {
        //define the query
        $sql = "SELECT * FROM member ORDER BY lname, fname";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //execute
        $statement->execute();

        //return all results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}