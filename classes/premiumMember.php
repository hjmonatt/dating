<?php

class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;

    /**
     * @return Array
     */
    public function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }

    /**
     * @param Array $indoorInterests
     */
    public function setIndoorInterests($indoorInterests): void
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * @return Array
     */
    public function getOutdoorInterests()
    {
        return $this->_outdoorInterests;
    }

    /**
     * @param Array $outdoorInterests
     */
    public function setOutdoorInterests($outdoorInterests): void
    {
        $this->_outdoorInterests = $outdoorInterests;
    }
}