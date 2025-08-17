<?php
namespace App\Libraries\astro\sweph\swephp;

use App\Controllers\BaseController;
use DateTime;
use DateTimeZone;
use CodeIgniter\Exceptions\CriticalError; // or
use RuntimeException; // or
use InvalidArgumentException;

    
// Swiss Ephemeris Calculation Flags
// define('SEFLG_JPLEPH', 1);              // use JPL ephemeris
// define('SEFLG_SWIEPH', 2);              // use SWISSEPH ephemeris, default
// define('SEFLG_MOSEPH', 4);              // use Moshier ephemeris
// define('SEFLG_HELCTR', 8);              // return heliocentric position
// define('SEFLG_TRUEPOS', 16);            // return true positions, not apparent
// define('SEFLG_J2000', 32);              // no precession, i.e. give J2000 equinox
// define('SEFLG_NONUT', 64);              // no nutation, i.e. mean equinox of date
// define('SEFLG_SPEED3', 128);            // speed from 3 positions (do not use it, SEFLG_SPEED is faster and more precise.)
// define('SEFLG_SPEED', 256);             // high precision speed (analyt. comp.)
// define('SEFLG_NOGDEFL', 512);           // turn off gravitational deflection
// define('SEFLG_NOABERR', 1024);          // turn off 'annual' aberration of light
define('SEFLG_ASTROMETRIC', SEFLG_NOABERR | SEFLG_NOGDEFL); // astrometric positions
// define('SEFLG_EQUATORIAL', 2048);       // equatorial positions are wanted
// define('SEFLG_XYZ', 4096);              // cartesian, not polar, coordinates
// define('SEFLG_RADIANS', 8192);          // coordinates in radians, not degrees
// define('SEFLG_BARYCTR', 16384);         // barycentric positions
// define('SEFLG_TOPOCTR', 32 * 1024);     // topocentric positions
// define('SEFLG_SIDEREAL', 64 * 1024);    // sidereal positions
// define('SEFLG_ICRS', 128 * 1024);       // ICRS (DE406 reference frame)
// define('SEFLG_DPSIDEPS_1980', 256 * 1024); // reproduce JPL Horizons 1962 - today to 0.002 arcsec.
// define('SEFLG_JPLHOR', SEFLG_DPSIDEPS_1980);
// define('SEFLG_JPLHOR_APPROX', 512 * 1024); // approximate JPL Horizons 1962 - today
// define('SEFLG_CENTER_BODY', 1024 * 1024);  // calculate position of center of body (COB) of planet, not barycenter of its system


if (!defined('SEFLG_ECLIPTIC')) {
    define('SEFLG_ECLIPTIC', 0); // Define the constant if it's missing
}
if (!defined('SEFLG_HELCTR')) {
    define('SEFLG_HELCTR', 256); // Define the constant if it's missing
}
if (!defined('SEFLG_EQUATORIAL')) {
    define('SEFLG_EQUATORIAL', 2048); // Define the constant if it's missing
}
if (!defined('SEFLG_SPEED')) {
    define('SEFLG_SPEED', 256); // Define the constant if it's missing
}
if (!extension_loaded('swephp')) {
    throw new RuntimeException('Swiss Ephemeris PHP extension is not loaded');
}
class Swephp extends BaseController{
    private $jul_ut;
    private $planets = [];
 	private  $jul_day_ET ;
    private $lon;
    private $lat;
    
    private $houses = [];

    public function __construct($year, $month, $day, $hour, $minute, $second, $timezone,$long,$lat) {
        $this->calculateJulianDate($year, $month, $day, $hour, $minute, $second, $timezone);
		$this->jul_day_ET = $this->jul_ut+ swe_deltat_ex($this->jul_ut,SEFLG_SWIEPH)['dt'];
        $this->calculatePlanets();
        // Check what date/time you're actually calculating for
 
        // Calculate Earth's position and add it to the planets array
        $earth = $this->calculateEarth();
        if ($earth) {
            $this->planets[] = $earth; // Append Earth's data to the planets array
        }
            
        
        $this->lat=$lat;
        $this->lon=$long;
        $this->calculateHouses();
        
    }

    private function calculateJulianDate($y, $m, $d, $h, $mi, $s, $timezone) {
        $tz = new DateTimeZone($timezone);
        $date = new DateTime("$y-$m-$d $h:$mi:$s", $tz);
        $date->setTimezone(new DateTimeZone('UTC'));
        $ut_hours = (float) ($date->format('H') + ($date->format('i') / 60) + ($date->format('s') / 3600));
        //$ephe=ROOTPATH . 'app/Libraries/astro/sweph/php-sweph 8.2/sweph/ephe/';
       // $ephe= '../ephe/sepl_18.se1';
       // echo('Swiss Ephemeris version: ' . swe_version());

       

        
        //swe_set_ephe_path($ephe);
        $this->jul_ut = swe_julday((int)$date->format('Y'), (int)$date->format('m'), (int)$date->format('d'), $ut_hours, SE_GREG_CAL);
		 
      //  $this->jul_ut  =2443747.1041667;
        echo '<script>console.log(" Julian Date: ' . $this->jul_ut . ' ");</script>';

        
    }

   

 private function calculatePlanets() {
    $flags =/*  SEFLG_TRUEPOS /* |  SEFLG_SPEED |*/ SEFLG_SWIEPH ;

    // Apply Delta T
   


    for ($i = SE_SUN; $i <= SE_VESTA; $i++) {
        if ($i == SE_EARTH) continue;
   

        $xx = swe_calc_ut($this->jul_day_ET, $i, $flags);
	//	
        if ($xx['rc'] < 0) continue;

        $this->planets[] = [
            'name' => swe_get_planet_name($i),
            'lng' => $xx[0],
            'declination' => $xx[1],
            'sign' => self::getZodiacSign($xx[0])
        ];
    }

    // 🔁 TRUE NODE with Delta T
    $pls = swe_calc_ut($this->jul_day_ET, SE_TRUE_NODE, $flags);
    if ($pls['rc'] >= 0) {
        $this->planets[] = [
            'name' => 'True Node',
            'lng' => $pls[0],
            'declination' => $pls[1],
            'sign' => self::getZodiacSign($pls[0])
        ];

        // 🔁 SOUTH NODE (opposite point)
        $southNodeLongitude = fmod($pls[0] + 180, 360);
        $this->planets[] = [
            'name' => 'South Node',
            'lng' => $southNodeLongitude,
            'declination' => -$pls[1],
            'sign' => self::getZodiacSign($southNodeLongitude)
        ];
    }
}


   private function calculateEarth() {
    
 
    $earth = swe_calc_ut($this->jul_day_ET, SE_EARTH, SEFLG_SPEED | SEFLG_HELCTR);
    if ($earth['rc'] >= 0) {
        return [
            'name' => 'Earth',
            'lng' => $earth[0],
            'declination' => $earth[1],
            'lat' => $earth[1],
            'speed' => $earth[3],
            'sign' => self::getZodiacSign($earth[0])
        ];
    }
    return null;
}

    private function calculateHouses() {
       
        $houses_result = swe_houses($this->jul_day_ET,  $this->lat,  $this->lon, "P");
        for ($i = 1; $i <= 12; $i++) {
            $cusp_longitude = $houses_result['cusps'][$i];
            $this->houses[] = [
                'house' => $i,
                'lng' => $cusp_longitude,
                'sign' => self::getZodiacSign($cusp_longitude)
            ];
        }
    }

    public function getPlanets() {
        return $this->planets;
    }

    public function getHouses() {
        return $this->houses;
    }

    private static function getZodiacSign($longitude) {
        $signs = ["Aries", "Taurus", "Gemini", "Cancer", "Leo", "Virgo", "Libra", "Scorpio", "Sagittarius", "Capricorn", "Aquarius", "Pisces"];
        return $signs[floor($longitude / 30) % 12];
    }

    private static function convertToDMS($decimal_degrees) {
        $degrees = floor($decimal_degrees);
        $minutes = floor(($decimal_degrees - $degrees) * 60);
        $seconds = round(($decimal_degrees - $degrees - $minutes / 60) * 3600, 2);
        return sprintf("%d° %02d' %05.2f\"", $degrees, $minutes, $seconds);
    }
}

