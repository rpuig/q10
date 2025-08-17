<?php

namespace App\Libraries\astro\zod;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\astro\sweph\Sweph;


include_once('constants.php');
class Zd extends BaseController {
private $sweph;
private $signs = array(0 => 'Ari', 'Tau', 'Gem', 'Can', 'Leo', 'Vir', 'Lib', 'Sco', 'Sag', 'Cap', 'Aqu', 'Pis');
private $sun_s;
private $asc_s;
private $moon_s;
private $planet_pos;

private $dob;
private $hob;
private $mob;
private $planet;
private $longitude;
private $declination;
private $house_pos;
private $sign_pos;



private $dob_ds;
private $hob_ds;
private $mob_ds;
private $planet_ds;
private $longitude_ds;
private $declination_ds;
private $house_pos_ds;
private $sign_pos_ds;


private $sign_name;
public $zd_display;
private $zd_natal;
private $zd_natal_ds;

private $zd_row_data;

public function __construct($db){

//Calculate chart

$this->set_zd_profile($db,"p");
$this->set_zd_profile($db,"d");
$this->generateZdDisplay($this->zd_natal->planets,$this->zd_natal->houses);

$this->set_Zd_Row();

}


private function is_DST($utnow, $datetimeZone) {
  // Convert the string $utnow to a Time object
  if (!$utnow instanceof Time) {
      $utnow = new Time($utnow, $datetimeZone);
  }

  // Check if Daylight Saving Time (DST) is in effect
  $dst_state = (bool)$utnow->format('I');

  // If DST is in effect, subtract one hour
  if ($dst_state) {
      $utnow->modify('-1 hour');
  }

  return $utnow;
}


//calculate Zd and store it
private Function set_zd_profile($row,$d_flag)

  {
         
      $swephsrc = '/zod/sweph';    //sweph MUST be in a folder no less than at this level     
    // Unset any variables not initialized elsewhere in the program
      unset($PATH,$out,$pl_name);  
      $PATH= getcwd();
      $unknown_time=$row['unknowntime'];
      $inmonth = $row['month'];
      $inday = $row['day'];
      $inyear = $row['year']; 

      if ( 
      $unknown_time==1)  {$row['hour'] ="12";$row['minute']="0";$row['timezone']=1;
      $i_longitude = "0";
      $i_latitude = "0" ;
      $insecs = "0";
      $inhours = $row['hour'];
      $inmins = $row['minute'];
    }

    else{

      $inhours = $row['hour'];
      $inmins = $row['minute'];
      $insecs = "0";
      $i_longitude=  $row['lon'];
      $i_latitude=  $row['lat'];
      

      }
      $planets=(object)[];
      $aspects=(object)[];

      $natal_aspects=(object)[];
      $natal_aspects->unknown_time=$unknown_time;
      $timezone_row=$row['timezone_txt'];
      //$datetimeZone=new DateTimeZone($timezone_row);
      $timeString=$inyear."-".$inmonth."-".$inday." ".$inhours.":".$inmins.":".$insecs;
      //$utnow = new DateTime($timeString, $datetimeZone);
      $utnow = Time::create($inyear,$inmonth,$inday,$inhours,$inmins,$insecs,$timezone_row);
      
      //change time for hd design calc 
     if ($d_flag=="d"){  
      //date = "1978-09-07 14:31:00.000000"
      //date after 90 days = "1978-06-07 14:31:00"
      //$utnow=$this->subtractDaysWithFractions($utnow,90);
      $utnow=$this->subtractMonthsFromDate( $utnow); 

      }      
      $utnow =$this->is_DST($utnow,$timezone_row);     
      $udaten=$utnow->format('d:m:Y');
      $utnw=$utnow->format('H:i:s');     
     
      $put=putenv("PATH=$PATH:$swephsrc");      
         
      $this->sweph=new Sweph($udaten,$utnw,$timezone_row,$i_longitude,$i_latitude);
  
      $planets=$this->sweph->planets();      
      $houses=$this->sweph->houses();
     // $planets
      
/*
      $cleanPlanets = [];
      foreach ($planets as $planet) {
          $cleanPlanets[] = [
              'name' => $planet['name'],
              'lng' => $planet['lng'],
              'declination' => $planet['declination'],
              'sign' => $planet['sign']
          ];
      }*/
    //  dd("Clean planets:", $cleanPlanets);
         

    //store the reuslts in one object 

    //for testing:
  /* 

$planets = [
    ["name" => "Sun", "lng" => 164.61416666666665, "declination" => 9.730622647687684e-05, "sign" => "Virgo"],
    ["name" => "Moon", "lng" => 222.53583333333333, "declination" => 3.7200622367672604, "sign" => "Scorpio"],
    ["name" => "Mercury", "lng" => 146.97222222222223, "declination" => 0.6152925541023532, "sign" => "Leo"],
    ["name" => "Venus", "lng" => 210.34972222222223, "declination" => -3.1408523142088463, "sign" => "Scorpio"],
    ["name" => "Mars", "lng" => 201.8477777777778, "declination" => 0.1037337682382192, "sign" => "Libra"],
    ["name" => "Jupiter", "lng" => 120.42805555555556, "declination" => 0.24993066540783704, "sign" => "Leo"],
    ["name" => "Saturn", "lng" => 155.3661111111111, "declination" => 1.4703294785280978, "sign" => "Virgo"],
    ["name" => "Uranus", "lng" => 223.29611111111112, "declination" => 0.3533317749238557, "sign" => "Scorpio"],
    ["name" => "Neptune", "lng" => 255.57611111111112, "declination" => 1.4368634842297512, "sign" => "Sagittarius"],
    ["name" => "Pluto", "lng" => 195.3575, "declination" => 16.642391094781352, "sign" => "Libra"],
    ["name" => "mean Node", "lng" => 177.34124861712277, "declination" => 0, "sign" => "Virgo"],
    ["name" => "true Node", "lng" => 176.76728072387266, "declination" => 0, "sign" => "Virgo"],
    ["name" => "mean Apogee", "lng" => 116.06491054252562, "declination" => -4.515044086120217, "sign" => "Cancer"],
    ["name" => "osc. Apogee", "lng" => 136.33367152211204, "declination" => -3.4308239090943924, "sign" => "Leo"],
    ["name" => "South Node", "lng" => 356.76728072387726, "declination" => 0, "sign" => "Pisces"],
    ["name" => "Earth", "lng" => 344.53585239563165, "declination" => -9.73061160708185e-05, "sign" => "Pisces"],
    ["name" => "Ascendant", "lng" => 261.93416666666667, "declination" => " ", "sign" => "Sagittarius"],
    ["name" => "North Node", "lng" => 176.76638888888888, "declination" => " ", "sign" => "Virgo"],
]; */
//dd($planets);       

    $natal_aspects->planets=$planets;
    $natal_aspects->houses=$houses;
    
    $natal_aspects->hob=$inhours; 
    $natal_aspects->mob=$inmins;

   
    //only for reference. not used for now in hd
    $this->hob=$inhours;
    $this->mob=$inmins;
    
if($d_flag=="d"){
  //  $natal_aspects->planets=$this->rotatePlanetaryPositions($natal_aspects->planets,90);  
    $this->zd_natal_ds=$natal_aspects;

}

else{
      
    $this->zd_natal=$natal_aspects;


      //store the reuslts in one object 
      
    $natal_aspects->planets_r=$planets;
    $natal_aspects->aspects_r=$aspects;
    $natal_aspects->hob=$inhours;
    $natal_aspects->mob=$inmins;
    

      //only for reference. not used for now in hd
      $this->hob=$inhours;
      $this->mob=$inmins;
      
     
     
      
  
  
    }


  }
  //converts the longitued returned by swetest to actual sign positions
private Function Convert_Longitude($longitude)
{

  
  $sign_pos_array=[];
  if ($longitude>=360){$longitude=$longitude-360;}
  $sign_num = floor($longitude / 30);
  $pos_in_sign = $longitude - ($sign_num * 30);
  $deg = floor($pos_in_sign);
  $full_min = ($pos_in_sign - $deg) * 60;
  $min = floor($full_min);
  $full_sec = round(($full_min - $min) * 60);

  if ($deg < 10)
  {
    $deg = "0" . $deg;
  }

  if ($min < 10)
  {
    $min = "0" . $min;
  }

  if ($full_sec < 10)
  {
    $full_sec = "0" . $full_sec;
  }
  $sign_pos_array["sign_name"]=$this->signs[$sign_num];//gets the sign name at each position
  $sign_pos_array["pos_degrees"]=$deg;
  $sign_pos_array["pos_minutes"]=$min;
  $sign_pos_array["pos_seconds"]=$full_sec;

  return $sign_pos_array;
  //return   ." ".  ."º". " " .  . "' " .  . chr(34);
}

private Function Convert_Declination($declination)
{

  $deg = floor(abs($declination));
  $min = round((abs($declination) - $deg) * 60);

  if ($deg < 10)
  {
    $deg = "0" . $deg;
  }

  if ($min < 10)
  {
    $min = "0" . $min;
  }

  if ($declination < 0)
  {
    return $deg . " S " . $min;
  }
  else
  {
    return $deg . " N " . $min;
  }
}

private function set_zd_result_display($natal_aspects){    

		$export_="";
///CORRECT THIS 
    //$longitude=(object)[];
		//$declination=(object)[];
		//$house_pos=(object)[];
		//$longitude=$natal_aspects->longitude; 
		//$declination=$natal_aspects->declination;	 
		//$house_pos=$natal_aspects->house_pos; 

		$hob=$natal_aspects->hob; 
		$mob=$natal_aspects->mob;

	//	$existing_name=$natal_aspects->name;	
	//	$pl_name=$natal_aspects->pname;
		
		$hr_ob = $hob;
		$min_ob = $mob;
	
		$ubt1 = 0;
		if (($hr_ob == 12) And ($min_ob == 0))
		{
		$ubt1 = 1;        // this person has an unknown birth time
		}

		$nbr_p=count($natal_aspects->planets_r->name) ;

		$counter_p=0;
    $export_.="(Reading precission ".(($natal_aspects->unknown_time ==1) ?' not accurate due to Birth Time Unknown )<br>': ' is accurate ! )<br>');
    do{
					$export_.=($natal_aspects->planets_r->name[$counter_p]); $export_.=(", ");
					$export_.=($natal_aspects->planets_r->long[$counter_p]); $export_.=(", ");
					$export_.=($natal_aspects->planets_r->decl[$counter_p]); $export_.=(", ");
					$export_.=($natal_aspects->planets_r->hse[$counter_p]);
					$export_.=("</br>");
						//print_r($cosmodynes_r->natal_d1->planets_r->name[$counter_p]);
				 
          $counter_p+=1;
			
		} while($counter_p<$nbr_p);

          $export_.=("</br>");
          $export_.=("</br><b>Aspects</b></br>");

          $export_.=("</br>Ascendant</br>");  
          $export_.=$natal_aspects->aspects_r->ascendant;

        // $export_.=$temp_long["sign_name"]." ".$temp_long["pos_degrees"]."º".$temp_long["pos_minutes"]."´".$temp_long["pos_seconds"]."\"";
          $export_.=("</br>");

          $export_.=("</br>Houses</br>");	        

          $output_array = array();  

          //get all houses from aspects for display
          foreach($natal_aspects->aspects_r->house as $a) 
          {
          //   array_push($output_array,$a);
          // }

          // //create sring for displau
          // foreach($output_array as $b)
          // {
          //$export_.=$b["sign_name"]." ".$b["pos_degrees"]."º".$b["pos_minutes"]."´".$b["pos_seconds"]."\"";
          $export_.=$a;
          $export_.=("</br>");		
          }


      $export_.=("</br>True Node</br>");
      $export_.=($natal_aspects->aspects_r->true_node);
      $export_.=("</br>South Node</br>");
      $export_.=($natal_aspects->aspects_r->south_node);
      $export_.=("</br>Earth</br>");
      $export_.=($natal_aspects->aspects_r->Earth);
    // $export_.=$temp_long["sign_name"]." ".$temp_long["pos_degrees"]."º".$temp_long["pos_minutes"]."´".$temp_long["pos_seconds"]."\"";
    
      $export_.=("</br>");
      $export_.=("</br>midheaven</br>");      
      $export_.=($natal_aspects->aspects_r->midheaven);
    // $export_.=$temp_long["sign_name"]." ".$temp_long["pos_degrees"]."º".$temp_long["pos_minutes"]."´".$temp_long["pos_seconds"]."\"";
      $export_.=("</br>"); 
      
      $rowCount = max(
        count($this->planet),
        count($this->longitude),  
        count($this->declination),
       
        count($this->house_pos)
  );



  $export_2="<div class=\"table-responsive\">";
  $export_2.= "<table class=\"table\">";
  $export_2.=  "<tr><th>Planet</th><th>Longitude</th><th>Declination</th><th>Sign Name</th><th>House Position</th></tr>";

    for ($i = 0; $i < $rowCount; $i++) {

      $export_2.=  "<tr>";
      $export_2.=  "<td>" . ($this->planet[$i] ?? '') . "</td>";
      $export_2.=  "<td>" . ($this->longitude[$i] ?? '') . "</td>";
      $export_2.=  "<td>" . ($this->declination[$i] ?? '') . "</td>";
      $export_2.=  "<td>" . ($this->sign_pos[$i] ?? '') . "</td>";
     
      $export_2.=  "<td>" . ($this->longitude[$i]["sign_name"] ?? 'error') . "</td>";
      $export_2.=  "<td>" . ($this->house_pos[$i] ?? '') . "</td>";
      $export_2.=  "</tr>";
    }
    $export_2.=  "</table></div>";


    $this->zd_display=$export_.$export_2;

	}
private function convertLngToLong($lng) {
    $signs = ["Ari", "Tau", "Gem", "Can", "Leo", "Vir", "Lib", "Sco", "Sag", "Cap", "Aqu", "Pis"];
    
    // Calculate the sign index and ensure it stays within 0-11
    $signIndex = intval($lng / 30) % 12;
    $sign = $signs[$signIndex];
    
    // Calculate degrees, minutes, and seconds without losing precision
    $degrees = fmod($lng, 30); // Get the remainder within the sign (0-30 degrees)
    $deg = intval($degrees); // Degrees part
    $fractionalDegrees = $degrees - $deg; // Fractional part for minutes and seconds
    
    $minutes = $fractionalDegrees * 60;
    $min = intval($minutes); // Minutes part
    $fractionalMinutes = $minutes - $min; // Fractional part for seconds
    
    $seconds = $fractionalMinutes * 60;
    $sec = intval(round($seconds)); // Seconds part, rounded to nearest integer
    
    return sprintf("%s %02d %02d %02d", $sign, $deg, $min, $sec);
}
// Function to generate HTML output for planets and houses
private function generateZdDisplay($planets, $houses) {
  // Start building the HTML output
  $html = <<<HTML
 
      <h1>Planets and Houses</h1>
      <div class="container">
  HTML;

  // Add Planets Card
  $html .= '<div class="card"><h2>Planets</h2><ul>';
  foreach ($planets as $planet) {
      $html .= sprintf(
          '<li><strong>%s</strong><br>Rel Longitude: %s<br>Abs Longitude: %s<br>Declination: %s<br>Sign: %s</li>',
          htmlspecialchars($planet['name']),
          $this->convertLngToLong($planet['lng']),
          htmlspecialchars($planet['lng']),
          htmlspecialchars($planet['declination']),
          htmlspecialchars($planet['sign'])
      );
  }
  $html .= '</ul></div>';

  // Add Houses Card
  $html .= '<div class="card"><h2>Houses</h2><ul>';
  foreach ($houses as $house) {
      $html .= sprintf(
          '<li><strong>House %s</strong><br>Longitude: %s<br>Sign: %s</li>',
          htmlspecialchars($house['house']),
          $this->convertLngToLong($house['lng']),
          htmlspecialchars($house['sign'])
      );
  }
  $html .= '</ul></div>';

  // Close the HTML
  $html .= '</div>';
  $this->zd_display=$html;
  return $html;
}
  public function get_zd_result_display(){

  return( $this->zd_display );//Return an html string for display of results

  }

public function get_zd_profile(){
$data=$this->zd_natal;
$data->aspects=$this->get_Zd_Row();
return $data;}

public function get_zd_profile_ds(){
return $this->zd_natal_ds;
  }

function subtractMonthsFromDate($date_i) {
    // Check if $date_i is a Time object, if not create one
    if (!$date_i instanceof Time) {
        // Ensure the date string is properly parsed
        try {
            $date = new Time($date_i);
        } catch (\Exception $e) {
            // Output error message to the browser console
            echo "<script>console.error('Error: Invalid date format');</script>";
            return;
        }
    } else {
        $date = $date_i;
    }

    // Debugging: Output the original date to the browser console
    echo "<script>console.log('Original date for Character calc: " . $date->toDateTimeString() . "');</script>";

    // Subtract 3 months from the date
    $date = $date->subMonths(3);
   // $date = $date->subDays(88);
    // Debugging: Output the modified date to the browser console
    echo "<script>console.log('Modified date for Design calc: " . $date->toDateTimeString() . "');</script>";

    // Return the modified date
    return $date->toDateTimeString();
}





function subtractDaysWithFractions($dateTime, $days) {
 // Split days into integer and fractional parts
 $integerDays = floor($days);
 $fractionalDays = $days - $integerDays;

 // Calculate seconds for the fractional part
 $fractionalSeconds = $fractionalDays * 24 * 60 * 60;

 // Get the timestamp of the original DateTime
 $timestamp = $dateTime->getTimestamp();

 // Subtract the integer part of days and the fractional part in seconds
 $newTimestamp = $timestamp - ($integerDays * 24 * 60 * 60) - $fractionalSeconds;

 // Create a new DateTime with the adjusted timestamp
 $resultDateTime =(object)[];
 $resultDateTime->setTimestamp($newTimestamp);

 return $resultDateTime;}


 private function set_Zd_Row(){
	$this->zd_row_data=[
    'sun'=> $this->zd_natal->planets[0]["sign"],
		'moon'=> $this->zd_natal->planets[1]["sign"],
		'ascendant'=> $this->zd_natal->houses[0]["sign"]
		
		];

}
public function  get_Zd_Row(){

	return $this->zd_row_data;


}


function toDMS($decimalDegrees) {
  $deg = floor($decimalDegrees);
  $min = floor(($decimalDegrees - $deg) * 60);
  $sec = round(($decimalDegrees - $deg - $min / 60) * 3600, 2);
  return "{$deg}° {$min}' {$sec}\"";
}

function get_sign_name($longitude) {
  // Convert the string to a float
  $longitude = floatval(trim($longitude)); // Trim and ensure conversion

  // Zodiac signs array
  $signs = [
      'Aries', 'Taurus', 'Gemini', 'Cancer', 
      'Leo', 'Virgo', 'Libra', 'Scorpio', 
      'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces'
  ];

  // Determine the sign index (each sign is 30° wide)
  $index = floor($longitude / 30) % 12; // Use modulus to avoid overflow for >360°
  return $signs[$index];
}



function dmsToDecimal($dms) {
  // Remove degree, minute, and second symbols and split the string by spaces
  preg_match('/(\d+)[^\d]*(\d+)[^\d]*(\d+(\.\d+)?)/', $dms, $matches);

  // Extract Degrees, Minutes, and Seconds
  $degrees = (float) $matches[1];
  $minutes = (float) $matches[2];
  $seconds = (float) $matches[3];

  // Convert to Decimal Degrees
  $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

  return $decimal;
}
function rotatePlanetaryPositions(array $positions, float $rotationDegree): array {
  $rotatedPositions = [];

  foreach ($positions as $planet => $position) {
      // Calculate the new position
      $newPosition = fmod($position["lng"] + $rotationDegree, 360);

      // If the result is negative, adjust it to be within 0-360
      if ($newPosition < 0) {
          $newPosition += 360;
      }

      // Save the new position in the array
      $rotatedPositions[$planet]["name"] = $position["name"];
      $rotatedPositions[$planet]["lng"] = $newPosition;
      $rotatedPositions[$planet]["declination"] = $position["declination"];
      $rotatedPositions[$planet]["sign"] = $position["sign"];
  }

  return $rotatedPositions;
}

}