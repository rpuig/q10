<?php
// Swiss Ephemeris PHP Extension Stubs for IDE support
// This file should NOT be included in your application

define('SE_SUN', 0);
define('SE_MOON', 1);
define('SE_MERCURY', 2);
define('SE_VENUS', 3);
define('SE_MARS', 4);
define('SE_JUPITER', 5);
define('SE_SATURN', 6);
define('SE_URANUS', 7);
define('SE_NEPTUNE', 8);
define('SE_PLUTO', 9);
define('SE_MEAN_NODE', 10);
define('SE_TRUE_NODE', 11);
define('SE_EARTH', 14);
define('SE_CHIRON', 15);
define('SE_CERES', 17);
define('SE_PALLAS', 18);
define('SE_JUNO', 19);
define('SE_VESTA', 20);
define('SE_GREG_CAL', 1);
define('SEFLG_SPEED', 256);
define('SEFLG_ECLIPTIC', 0);
define('SEFLG_HELCTR', 8);
define('SEFLG_EQUATORIAL', 2048);

// Function stubs
function swe_calc_ut($tjd_ut, $ipl, $iflag) {}
function swe_get_planet_name($ipl) {}
function swe_julday($year, $month, $day, $hour, $gregflag) {}
function swe_houses($tjd_ut, $geolat, $geolon, $hsys) {}
function swe_set_ephe_path($path) {}