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
     * @return Array - Premium Member's indoor interests
     */
    public function getIndoorInterests() : array
    {
        return $this->_indoorInterests;
    }

    /**
     * @param Array $indoorInterests
     */
    public function setIndoorInterests($indoorInterests)
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * @return Array - Premium Member's outdoor interests
     */
    public function getOutdoorInterests(): array
    {
        return $this->_outdoorInterests;
    }

    /**
     * @param Array $outdoorInterests
     */
    public function setOutdoorInterests($outdoorInterests)
    {
        $this->_outdoorInterests = $outdoorInterests;
    }
}