<?php

/**
 * PremiumMember class
 * takes the user's information and stores it as an object
 * @author Heather Monatt
 */

class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;

    /**
     * @return string - Premium Member's indoor interests
     */
    public function getIndoorInterests() : string
    {
        return $this->_indoorInterests;
    }

    /**
     * @param string $indoorInterests
     */
    public function setIndoorInterests(string $indoorInterests)
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * @return string - Premium Member's outdoor interests
     */
    public function getOutdoorInterests(): string
    {
        return $this->_outdoorInterests;
    }

    /**
     * @param string $outdoorInterests
     */
    public function setOutdoorInterests(string $outdoorInterests)
    {
        $this->_outdoorInterests = $outdoorInterests;
    }


}