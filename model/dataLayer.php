<?php
/*
 * Heather Monatt
 * February 22nd, 2021
 * model.dataLayer.php
 * returns data for my dating website
 *
 */
class DataLayer
{

    /**
     * getIndoor() - returns an array of indoor interests
     * @return - string[]
     */
    function getIndoor()
    {
        return array("Meditating", "Movies/TV", "Cooking", "Board Games", "Puzzles", "Reading",
            "Playing Cards", "Dancing");
    }

    /**
     * getOutdoor() - returns an array of outdoor interests
     * @return - string[]
     */
    function getOutdoor()
    {
        return array("Hiking", "Biking", "Swimming", "Running", "Sports", "Foraging",
            "Climbing", "Gardening");

    }

    /**
     * getGender() - returns an array of genders
     * @return - string[]
     */
    function getGender()
    {
        return array("Male", "Female", "Non-Binary");

    }

    /**
     * getSeeking() - returns an array of genders
     * @return - string[]
     */
    function getSeeking()
    {
        return array("Male", "Female", "Anyone");

    }

    /**
     * getState() - returns an array of states
     * @return - string[]
     */
    function getStates()
    {
        return array('Alabama',
            'Alaska',
            'Arizona',
            'Arkansas',
            'California',
            'Colorado',
            'Connecticut',
            'Delaware',
            'District of Columbia',
            'Florida',
            'Georgia',
            'Hawaii',
            'Idaho',
            'Illinois',
            'Indiana',
            'Iowa',
            'Kansas',
            'Kentucky',
            'Louisiana',
            'Maine',
            'Maryland',
            'Massachusetts',
            'Michigan',
            'Minnesota',
            'Mississippi',
            'Missouri',
            'Montana',
            'Nebraska',
            'Nevada',
            'New Hampshire',
            'New Jersey',
            'New Mexico',
            'New York',
            'North Carolina',
            'North Dakota',
            'Ohio',
            'Oklahoma',
            'Oregon',
            'Pennsylvania',
            'Rhode Island',
            'South Carolina',
            'South Dakota',
            'Tennessee',
            'Texas',
            'Utah',
            'Vermont',
            'Virginia',
            'Washington',
            'West Virginia',
            'Wisconsin',
            'Wyoming');

    }
}
