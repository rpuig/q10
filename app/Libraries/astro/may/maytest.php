<?php


include 'may_constants.php';


/**TESTING****/



// echo $mayan_result->get_index_from_tone_seal("dragon",1);
// echo("<br>");
// echo $mayan_result->get_index_from_tone_seal("hand","resonant");

// $time="07-09-1978 12:00";
// $mayan_result=new may($tzolkin0,$time);
// $mayan_result_print=$mayan_result->export_my_for_match();
// echo("1:<br>");
// foreach($mayan_result_print2 as $value){

//     echo $value . "<br>";
// }

$time2="07-05-1970 12:00";
$mayan_result2=new may($tzolkin0,$time2);
$mayan_result_print2=$mayan_result2->export_my_for_match();
echo("2:<br>");
foreach($mayan_result_print2 as $value){
    echo $value . "<br>";
}



/**END TESTING****/

class may{
    
    
private $time_z;
private $tzolkin;
private $p_tribe;
private $p_kin,$p_guide,$p_analogue,$p_antipode,$p_occult;


public function __construct($tzolkin_r,$time_r){

$this->tzolkin=$tzolkin_r;
$this->time_z=$time_r;

}




private function parse_time_string($time_String)
{

		$time_c=$time_String;
		$time_frame=substr($time_c, 6);
	

		if ($time_frame == "AM") {
			
			$time_c = substr($time_c, 0, strpos($time_c, $time_frame));
            
            
            if ($time_c=="12:00"){
				$time_c="00:00";
				

			}

		}
		else if ($time_frame="PM"){


			$time_temp = substr($time_c, 0, strpos($time_c, $time_frame));
			$time_hour=substr($time_temp,0,2);
			$time_mins=substr($time_temp,3,3);
            $time_hour=(int)$time_hour;
            
			if ($time_hour>12){
				
					$time_hour=$time_hour;
				
			}
			else{
                
                    $time_hour+=12;
            }
			
			$time_c=(string)$time_hour.":".$time_mins;
		
		

		}
            $time_c=trim($time_c);
            
	return $time_c;
			

    }


public function is_leap($date_r){
    
     $leap = 0;
     
     
        
        $year= date_format($date_r,"Y");
        
        $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
        
        return $leap;
        
        //echo $year . ' ' . ($leap ? 'is' : 'is not') . ' a leap year.';

}
/*returns 28 or 1 if month is 2 and hour is morning*/
public function leapday($flag,$date){
    
         $day= date_format($date,"d");
         $month= date_format($date,"m"); 
         $hour=date_format($date,"H"); 
         
            if ($flag) {
                    
                            if ($month==2)
                            
                            {
                                if ($day==29)
                                {
                                        if ($hour<12)
                                        {
                                        return 28;
                                        }
                                        else 
                                        {
                                        return 1; 
                                        }
                                }
                            }
                            
                            else{
                            return $day;
                            }
                    }
                
                else {
                    return $day;
                }
    return $day;
}


public function find_year_mumber($year)
{

$year_numb=array("1920"=>72,"1921"=>177,"1922"=>22,"1923"=>127,"1924"=>23,"1925"=>77,"1926"=>182,"1927"=>27,"1928"=>132,"1929"=>237,

"1930"=>82,"1931"=>187,"1932"=>32,"1933"=>137,"881934"=>242,"1935"=>87,"891936"=>192,"1937"=>37,"901938"=>142,"1939"=>247,"1940"=>92,"1941"=>197,

"1942"=>42,"1943"=>147,"1944"=>252,"1945"=>97,"1946"=>202,"1947"=>47,"1948"=>152,"1949"=>257,"1950"=>102,"1951"=>207,"1952"=>52,"1953"=>157,

"1954"=>2,"1955"=>107,"1956"=>212,"1957"=>57,"1958"=>162,"1959"=>7,"1960"=>112,"1961"=>217,"1962"=>62,"1963"=>167,"1964"=>12,"1965"=>117,

"1966"=>222,"1967"=>67,"1968"=>172,"1969"=>17,"1970"=>122,"1971"=>227,"1972"=>72,"1973"=>177,"1974"=>22,"1975"=>127,"1976"=>232,"1977"=>77,

"1978"=>182,"1979"=>27,"1980"=>132,"1981"=>237,"1982"=>82,"1983"=>187,"1984"=>32,"1985"=>137,"1986"=>242,"1987"=>87,"1988"=>192,"1989"=>37,

"1990"=>142,"1991"=>247,"1992"=>92,"1993"=>197,"1994"=>42,"1995"=>147,"1996"=>252,"1997"=>97,"1998"=>202,"1999"=>47,"2000"=>152,"2001"=>257,

"2002"=>102,"2003"=>207,"2004"=>52,"2005"=>157,"2006"=>2,"2007"=>107,"2008"=>212,"2009"=>57,"2010"=>162,"2011"=>7,"2012"=>112,"2013"=>217,

"2014"=>62,"2015"=>167,"2016"=>12,"2017"=>117,"2018"=>222,"2019"=>67,"2020"=>172,"2021"=>17,"2022"=>122,"2023"=>227,"2024"=>72,"2025"=>177,

"2026"=>22,"2027"=>127,"2028"=>232,"2029"=>77,"2030"=>182,"2031"=>27,"2032"=>132,"2033"=>237,"2034"=>82,"2035"=>187,"2036"=>32,"2037"=>137,

"2038"=>242,"2039"=>87,"2040"=>192,"2041"=>37,"2042"=>142,"2043"=>247,"2044"=>92,"2045"=>197,"2046"=>42,"2047"=>147,"2048"=>252,"2049"=>97,

"2050"=>202,"2051"=>47,"2052"=>152,"2053"=>257,"2054"=>102,"2055"=>207,"2056"=>52,"2057"=>157,"2058"=>2,"2059"=>107,"2060"=>212,"2061"=>57,

"2062"=>162,"2063"=>7,"2064"=>112);
    
$year_mumber_r=$year_numb[$year];

return $year_mumber_r;
}



public function find_month_number($month){
  
    
    $month_numb=array(0,31,59,90,120,151,181,212,243,13,44,74);
    
    $month_r=$month_numb[$month-1];
      
   return $month_r;
}



/* Return kin numeric index position in the tzolkin array*/
public function get_index_from_tone_seal($seal_i,$tone_i){
    
    $index=0;
    $seal=$seal_i;
    $tone=$tone_i;
    
    $array=$this->tzolkin;
    
    if (!is_array($array)) 

        return FALSE;
    //Allows for the use of numeric value instead of text 
    if ( is_numeric($seal_i)){
     
     switch ($seal_i){
            
            case 1:
                $seal="dragon";
                break;
            case 2:
                $seal="wind";
                break;
            case 3:
                $seal="night";
                break;
            case 4:
                $seal="seed";
                break;
            case 5:
                $seal="snake";
                break;
            case 6:
                $seal="worldBridger";
                break;
            case 7:
                $seal="hand";
                break;
            case 8:
                $seal="star";
                break;                
            case 9:
                $seal="moon";
                break;
            case 10:
                $seal="dog";
                break;
            case 11:
                $seal="monkey";
                break;
            case 12:
                $seal="human";
                break;
            case 13:
                $seal="skyWalker";
                break;
            case 14:
                $seal="wizard";
                break;
            case 15:
                $seal="eagle";
                break;
            case 16:
                $seal="warrior";
                break;
            case 17:
                $seal="earth";
                break;
            case 18:
                $seal="mirror";
                break;
            case 19:
                $seal="storm";
                break;
            case 20:
                $seal="sun";
                break;            
        }
    }
    
    if ( is_numeric($tone_i)){
     switch ($tone_i){
            
            case 1:
                $tone="magnetic";
                break;
            case 2:
                $tone="lunar";
                break;
            case 3:
                $tone="electric";
                break;
            case 4:
                $tone="selfexisting";
                break;
            case 5:
                $tone="overtone";
                break;
            case 6:
                $tone="rhythmic";
                break;
            case 7:
                $seal="resonant";
                break;
            case 8:
                $tone="galactic";
                break;                
            case 9:
                $tone="solar";
                break;
            case 10:
                $tone="planetary";
                break;
            case 11:
                $tone="spectral";
                break;
            case 12:
                $tone="crystal";
                break;
            case 13:
                $tone="cosmic";
                break;
           
        }
    }
    $k=0; //Counter
    foreach ($array as $value) {
        /*Check this index BUG**/
        $k++;
                    
                    if (($value[0]==$seal)&&($value[1]==$tone)){
                        
                        $seal=$seal_i;
                        $tone=$tone_i;
                        
                        $index=$k;

                        break;

                        return $index; /* returns kin numeric index position in the
                        tzolkin array*/
                    }
                    
        
        
            }
    
   
    
    
    return $index;
} 


/*Convert seal and tones into number*/
public function get_toneSeal_numb($seal_i,$tone_i){
        
       /*determine seal name*/
        switch ($seal_i){
            
            case "dragon":
                $seal=1;
                break;
            case "wind":
                $seal=2;
                break;
            case "night":
                $seal=3;
                break;
            case "seed":
                $seal=4;
                break;
            case "snake":
                $seal=5;
                break;
            case "worldBridger":
                $seal=6;
                break;
            case "hand":
                $seal=7;
                break;
            case "star":
                $seal=8;
                break;                
            case "moon":
                $seal=9;
                break;
            case "dog":
                $seal=10;
                break;
            case "monkey":
                $seal=11;
                break;
            case "human":
                $seal=12;
                break;
            case "skyWalker":
                $seal=13;
                break;
            case "wizard":
                $seal=14;
                break;
            case "eagle":
                $seal=15;
                break;
            case "warrior":
                $seal=16;
                break;
            case "earth":
                $seal=17;
                break;
            case "mirror":
                $seal=18;
                break;
            case "storm":
                $seal=19;
                break;
            case "sun":
                $seal=20;
                break;            
        } 
        
        switch ($tone_i){
            case "magnetic":
                $tone=1;
                break;
            case "lunar":
                $tone=2;
                break;            
            case "electric":
                $tone=3;
                break;
            case "selfexisting":
                $tone=4;
                break;
            case "overtone":
                $tone=5;
                break;
            case "rhythmic":
                $tone=6;
                break;            
            case "resonant":
                $tone=7;
                break;
            case "galactic":
                $tone=8;
                break;
            case "solar":
                $tone=9;
                break;
            case "planetary":
                $tone=10;
                break;
            case "spectral":
                $tone=11;
                break;
            case "crystal":
                $tone=12;
                break;
            case "cosmic":
                $tone=13;
                break;                       
        }
        
        $kin=array($seal,$tone);
    
         return $kin;
        
    }

    public function obtain_kin($sum,$tzolkin){
    
 
    
    
         /*dragon wind night seed snake worldBridger hand star moon dog 
           monkey human skyWalker wizard eagle warrior earth mirror storm sun*/
                    
       
                
          return $tzolkin[$sum];
}
public function guide($seal,$tone){
   $guide[0] = $seal;
   $guide[1]=$tone;
   
   
            switch ($tone){
                case 1:
                $guide[0] = $seal;
                break; 
                case 6:
                $guide[0] = $seal;
                break;
                case 11:
                $guide[0] = $seal;
                break;
                case 2:
                $guide[0] = $seal + 12;
                If( $guide>260)
                {
                $guide[0] =$seal-8;
                }
                break;     
                case 7:
                $guide[0] = $seal + 12;
                If($guide>260)
                {
                $guide[0] =$seal-8;
                 }
                break;                  
                case 12:
                $guide[0]= $seal + 12;
                If( $guide>260)
                {
                $guide[0]=$seal-8;
                }
                break;                  
                  
                case 3:
               $guide[0]= $seal+4;
                If( $guide[0]>260)
                {
                $guide[0]=$seal-16;
                }
                break;                   
                case 8:
                $guide[0]= $seal+4;
                If( $guide[0]>260)
                {
                $guide[0]=$seal-16;
                }
                break;                   
                case 13:
                $guide[0]= $seal+4;
                If( $guide[0]>260)
                {
                $guide[0]=$seal-16;    
                }
                break; 

                case 4:
                $guide[0]= $seal+16;
                  
                If( $guide>260)
                {
                $guide[0]=$seal-4;
                }
                break;                   
                case 9:
                $guide[0]= $seal+16;
                If( $guide>260)
                {
                $guide[0]=$seal-4;
                }
                break;                   
                       
                case 5:
                $guide[0]= $seal+8;
                   
                If( $guide>260)
                 {
                $guide[0]=$seal-12;
                 }
                break;                   
                                    
                case 10:
                $guide[0]= $seal+8; 
                
                If( $guide[0]>260)
                 {
                $guide[0]=$seal-12;
                 }
                break;                
   
            }
            
      
          return $guide;    
      
    
        }
/*Caculates analogue seal */
public function analogue($seal,$tone){
    
    $analogue=array($seal-5,$tone);
    return $analogue;
}
/*Caculates antipode seal */
public function antipode($seal,$tone){
    
    $antipode=array($seal-10,$tone);
    return $antipode;
    
}
/*Caculates occult seal */
public function occult($seal,$tone){
    
    $occult=array($seal-3,14-$tone);
    return $occult;
    
}



public function tribe($seal){
    $tribe="";
            
    switch($seal){
            case "dragon":                
                $tribe="red";
                break;
            case "wind":                
                $tribe="white";
                break;
            case "night":                
                $tribe="blue";
                break;
            case "seed":                
                $tribe="yellow";
                break;
            case "snake":               
                $tribe="red";
                break;
            case "worldBridger":                
                $tribe="white";
                break;
            case "hand":               
                $tribe="blue";
                break;
            case "star":                
                $tribe="yellow";
                break;                
            case "moon":               
                $tribe="red";
                break;
            case "dog":                
                $tribe="white";
                break;
            case "monkey":                
                $tribe="blue";
                break;
            case "human":                
                $tribe="yellow";
                break;
            case "skyWalker":                
                $tribe="red";
                break;
            case "wizard":               
                $tribe="white";
                break;
            case "eagle":                
                $tribe="blue";
                break;
            case "warrior":                
                $tribe="yellow";
                break;
            case "earth":                
                $tribe="red";
                break;
            case "mirror":                
                $tribe="white";
                break;
            case "storm":                
                $tribe="blue";
                break;
            case "sun":               
                $tribe="yellow";
                break;            
            }   




    return $tribe;
}


public function castle($kin_a,$guide_a,$analogue_a,$antipode_a,$occult_a,$tibe_a){  
    
    $castle_r= new  stdClass();
    
    $castle_r->kin_seal= $kin_a[0];
    $castle_r->kin_tone= $kin_a[1];
    $castle_r->kin_number= $kin_a[2];
    $castle_r->guide_seal= $guide_a[0];
    $castle_r->guide_tone= $guide_a[1];
    
    $castle_r->analogue_seal= $analogue_a[0];
    $castle_r->analogue_tone= $analogue_a[1];
    
    $castle_r->antipode_seal= $antipode_a[0];
    $castle_r->antipode_tone= $antipode_a[1];
    
    $castle_r->occult_seal= $occult_a[0];
    $castle_r->occult_tone= $occult_a[1];

    $castle_r->tribe=$tibe_a;
    //  $castle_r->occult_numb= $occult_a[2];
   
  return $castle_r;
    
}
public function export_my_for_match(){

//$my_result=new stdClass();

$Time=$this->time_z;
$Dateformat = "d-m-Y H:i";
$date = DateTime::createFromFormat($Dateformat, $Time);
$leap=intval($this->leapday($this->is_leap($date),$date));
$yearbr=$this->find_year_mumber(date_format($date,"Y"));
$nbr=$this->find_month_number(date_format($date,"m"));
$total=$leap+$yearbr+$nbr;// absolute kin number 

$kin_index=$total>260?$total-260:$total;

/*Calculate kin*/

$result=$this->obtain_kin($kin_index,$this->tzolkin);
$kin=$result;

/*Tell tribe*/

$tribe=$this->tribe($kin[0]);
//var_dump($tribe);

/*get the number for the text version of kin*/

$kin_num=$this->get_toneSeal_numb($kin[0],$kin[1]);
array_push($kin,$kin_index);

/*Calculate guide*/
$guide=$this->guide($kin_num[0],$kin_num[1]);
$guide_nbr=$this->get_index_from_tone_seal($guide[0],$guide[1]);
$guide=$this->tzolkin[$guide_nbr];
//////BUG
/*Calculate analogue*/
$analogue=$this->analogue($kin_num[0],$kin_num[1]);
$analogue_nbr=$this->get_index_from_tone_seal($analogue[0],$analogue[1]);
$analogue=$this->tzolkin[$analogue_nbr];

/*Calculate antipode */
$antipode=$this->antipode($kin_num[0],$kin_num[1]);
$antipode_nbr=$this->get_index_from_tone_seal($antipode[0],$antipode[1]);
$antipode=$this->tzolkin[$antipode_nbr];

/*Calculate occult*/

$occult=$this->occult($kin_num[0],$kin_num[1]);
$occult_nbr=$this->get_index_from_tone_seal($occult[0],$occult[1]);
$occult=$this->tzolkin[$occult_nbr];

//echo "occult : ".$occult[0]." ".$occult[1];
//$my_result->occult=$occult;
###########################################";

$castle_result=$this->castle($kin,$guide,$analogue,$antipode,$occult,$tribe);
    
return $castle_result; /*returns arrays of each result*/

}






}// end of class May
?>