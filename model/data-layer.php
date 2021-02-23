<?php
/*
 * Heather Monatt
 * February 22nd, 2021
 * model.data-layer.php
 * returns data for my dating website
 *
 */

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

