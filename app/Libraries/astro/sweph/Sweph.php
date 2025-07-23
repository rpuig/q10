<?php

namespace App\Libraries\astro\sweph;

use App\Controllers\BaseController;

use App\Libraries\astro\sweph\swephp\Swephp;

class Sweph extends BaseController
{
    private $truenode;
    private $planets;
    private $houses;

    public function __construct($udaten, $utnw, $timezone, $my_longitude, $my_latitude, $serverName = null, $documentRoot = null)
    {
        parent::initController(
            \Config\Services::request(),
            \Config\Services::response(),
            \Config\Services::logger()
        );

        // Use the passed $serverName or fall back to the environment variable or default to localhost
        $serverName = $serverName ?? getenv('SERVER_NAME') ?: 'localhost';
        $documentRoot = $documentRoot ?? getenv('DOCUMENT_ROOT') ?: '';

       // $Sweph_path = ROOTPATH . 'app/Libraries/astro/sweph';
     //$Sweph_path = ROOTPATH . 'app/Libraries/astro/sweph/swephp';


        // Check if running on a local server based on the environment variables
        /* if (stripos($this->baseURL, $this->local_server_domain) !== false) {
            $Sweph_path = ROOTPATH . 'app/Libraries/astro/sweph';
        }
 */
        //example input: swetest -b01.01.2025 -ut12:30 -ge40:42:46,74:00:21 -house40.7,-74.0,p -p0123456789mtA -fPlsg
        //swetest -b7.9.1978 -n1 -s1 -fPL -pp0123456789MtN -house40.4167,3.7033 -ut12:30 
       // $command="$Sweph_path/swetest -edir$Sweph_path -b$udaten -ut$utnw   -eswe -house$my_longitude,$my_latitude, -fPldj -g, -head 2>&1";
        
        list($day, $month, $year) = explode(":", $udaten);
        list($hour, $minute) = explode(":", $utnw);

        
        $astro = new Swephp($year, $month, $day, $hour, $minute, 0,$timezone,$my_longitude,$my_latitude);
        
        
       
        $this->planets =  $astro->getPlanets();
        $this->houses =  $astro->getHouses();

       
    }

    public function planets()
    {
        return $this->planets;
    }

    public function houses()
    {
        return $this->houses;
    }


    public function swephp(){

      
              


    
}
}
