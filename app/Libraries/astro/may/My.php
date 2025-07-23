<?php

namespace app\Libraries\astro\may;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
Class My extends BaseController{        
                                                    
private $tzolkin=  array(
      
    "1"=>array("dragon","magnetic"),"2"=>array("wind","lunar"),"3"=>array("night","electric"),"4"=>array("seed","selfexisting"),
    "5"=>array("snake","overtone"),"6"=>array("worldBridger","rhythmic"),"7"=>array("hand","resonant"),"8"=>array("star","galactic"),
    "9"=>array("moon","solar"),"10"=>array("dog","planetary"),"11"=>array("monkey","spectral"),"12"=>array("human","crystal"),
    "13"=>array("skyWalker","cosmic"),"14"=>array("wizard","magnetic"),"15"=>array("eagle","lunar"),"16"=>array("warrior","electric"),"17"=>array("earth","selfexisting"),
    "18"=>array("mirror","overtone"),"19"=>array("storm","rhythmic"),"20"=>array("sun","resonant"),
    
    "21"=>array("dragon","galactic"),"22"=>array("wind","solar"),"23"=>array("night","planetary"),"24"=>array("seed","spectral"),
    "25"=>array("snake","crystal"),"26"=>array("worldBridger","cosmic"),"27"=>array("hand","magnetic"),"28"=>array("star","lunar"),"29"=>array("moon","electric"),"30"=>array("dog","selfexisting"),
    "31"=>array("monkey","overtone"),"32"=>array("human","rhythmic"),"33"=>array("skyWalker","resonant"),"34"=>array("wizard","galactic"),
    "35"=>array("eagle","solar"),"36"=>array("warrior","planetary"),"37"=>array("earth","spectral"),"38"=>array("mirror","crystal"),
    "39"=>array("storm","cosmic"),"40"=>array("sun","magnetic"),
   
    "41"=>array("dragon","lunar"),"42"=>array("wind","electric"),"43"=>array("night","selfexisting"),
    "44"=>array("seed","overtone"),"45"=>array("snake","rhythmic"),"46"=>array("worldBridger","resonant"),"47"=>array("hand","galactic"),
    "48"=>array("star","solar"),"49"=>array("moon","planetary"),"50"=>array("dog","spectral"),"51"=>array("monkey","crystal"),
    "52"=>array("human","cosmic"),"53"=>array("skyWalker","magnetic"),"54"=>array("wizard","lunar"),"55"=>array("eagle","electric"),"56"=>array("warrior","selfexisting"),
    "57"=>array("earth","overtone"),"58"=>array("mirror","rhythmic"),"59"=>array("storm","resonant"),"60"=>array("sun","galactic"),
    
    "61"=>array("dragon","solar"),"62"=>array("wind","planetary"),"63"=>array("night","spectral"),"64"=>array("seed","crystal"),
    "65"=>array("snake","cosmic"),"66"=>array("worldBridger","magnetic"),"67"=>array("hand","lunar"),"68"=>array("star","electric"),"69"=>array("moon","selfexisting"),
    "70"=>array("dog","overtone"),"71"=>array("monkey","rhythmic"),"72"=>array("human","resonant"),"73"=>array("skyWalker","galactic"),
    "74"=>array("wizard","solar"),"75"=>array("eagle","planetary"),"76"=>array("warrior","spectral"),"77"=>array("earth","crystal"),
    "78"=>array("mirror","cosmic"),"79"=>array("storm","magnetic"),"80"=>array("sun","lunar"),
    
    "81"=>array("dragon","electric"),"82"=>array("wind","selfexisting"),"83"=>array("night","overtone"),"84"=>array("seed","rhythmic"),"85"=>array("snake","resonant"),
    "86"=>array("worldBridger","galactic"),"87"=>array("hand","solar"),"88"=>array("star","planetary"),"89"=>array("moon","spectral"),"90"=>array("dog","crystal"),
    "91"=>array("monkey","cosmic"),"92"=>array("human","magnetic"),"93"=>array("skyWalker","lunar"),"94"=>array("wizard","electric"),"95"=>array("eagle","selfexisting"),
    "96"=>array("warrior","overtone"),"97"=>array("earth","rhythmic"),"98"=>array("mirror","resonant"),"99"=>array("storm","galactic"),
    "100"=>array("sun","solar"),
    
    "101"=>array("dragon","planetary"),"102"=>array("wind","spectral"),"103"=>array("night","crystal"),"104"=>array("seed","cosmic"),"105"=>array("snake","magnetic"),"106"=>array("worldBridger","lunar"),
    "107"=>array("hand","electric"),"108"=>array("star","selfexisting"),
    "109"=>array("moon","overtone"),"110"=>array("dog","rhythmic"),"111"=>array("monkey","resonant"),"112"=>array("human","galactic"),
    "113"=>array("skyWalker","solar"),"114"=>array("wizard","planetary"),"115"=>array("eagle","spectral"),"116"=>array("warrior","crystal"),
    "117"=>array("earth","cosmic"),"118"=>array("mirror","magnetic"),"119"=>array("storm","lunar"),"120"=>array("sun","electric"),
    
    "121"=>array("dragon","selfexisting"),"122"=>array("wind","overtone"),"123"=>array("night","rhythmic"),"124"=>array("seed","resonant"),"125"=>array("snake","galactic"),
    "126"=>array("worldBridger","solar"),"127"=>array("hand","planetary"),"128"=>array("star","spectral"),"129"=>array("moon","crystal"),
    "130"=>array("dog","cosmic"),"131"=>array("monkey","magnetic"),"132"=>array("human","lunar"),"133"=>array("skyWalker","electric"),"134"=>array("wizard","selfexisting"),
    "135"=>array("eagle","overtone"),"136"=>array("warrior","rhythmic"),"137"=>array("earth","resonant"),"138"=>array("mirror","galactic"),
    "139"=>array("storm","solar"),"140"=>array("sun","planetary"),
    
    "141"=>array("dragon","spectral"),"142"=>array("wind","crystal"),"143"=>array("night","cosmic"),"144"=>array("seed","magnetic"),"145"=>array("snake","lunar"),
    "146"=>array("worldBridger","electric"),"147"=>array("hand","selfexisting"),
    "148"=>array("star","overtone"),"149"=>array("moon","rhythmic"),"150"=>array("dog","resonant"),"151"=>array("monkey","galactic"),
    "152"=>array("human","solar"),"153"=>array("skyWalker","planetary"),"154"=>array("wizard","spectral"),"155"=>array("eagle","crystal"),
    "156"=>array("warrior","cosmic"),"157"=>array("earth","magnetic"),"158"=>array("mirror","lunar"),"159"=>array("storm","electric"),"160"=>array("sun","selfexisting"),
    
    "161"=>array("dragon","overtone"),"162"=>array("wind","rhythmic"),"163"=>array("night","resonant"),"164"=>array("seed","galactic"),
    "165"=>array("snake","solar"),"166"=>array("worldBridger","planetary"),"167"=>array("hand","spectral"),"168"=>array("star","crystal"),
    "169"=>array("moon","cosmic"),"170"=>array("dog","magnetic"),"171"=>array("monkey","lunar"),"172"=>array("human","electric"),"173"=>array("skyWalker","selfexisting"),
    "174"=>array("wizard","overtone"),"175"=>array("eagle","rhythmic"),"176"=>array("warrior","resonant"),"177"=>array("earth","galactic"),
    "178"=>array("mirror","solar"),"179"=>array("storm","planetary"),"180"=>array("sun","spectral"),
  
    "181"=>array("dragon","crystal"),"182"=>array("wind","cosmic"),"183"=>array("night","magnetic"),"184"=>array("seed","lunar"),"185"=>array("snake","electric"),
    "186"=>array("worldBridger","selfexisting"),"187"=>array("hand","overtone"),"188"=>array("star","rhythmic"),"189"=>array("moon","resonant"),"190"=>array("dog","galactic"),
    "191"=>array("monkey","solar"),"192"=>array("human","planetary"),"193"=>array("skyWalker","spectral"),"194"=>array("wizard","crystal"),
    "195"=>array("eagle","cosmic"),"196"=>array("warrior","magnetic"),"197"=>array("earth","lunar"),"198"=>array("mirror","electric"),"199"=>array("storm","selfexisting"),
    "200"=>array("sun","overtone"),
    
    "201"=>array("dragon","rhythmic"),"202"=>array("wind","resonant"),"203"=>array("night","galactic"),
    "204"=>array("seed","solar"),"205"=>array("snake","planetary"),"206"=>array("worldBridger","spectral"),"207"=>array("hand","crystal"),
    "208"=>array("star","cosmic"),"209"=>array("moon","magnetic"),"210"=>array("dog","lunar"),"211"=>array("monkey","electric"),"212"=>array("human","selfexisting"),
    "213"=>array("skyWalker","overtone"),"214"=>array("wizard","rhythmic"),"215"=>array("eagle","resonant"),"216"=>array("warrior","galactic"),
    "217"=>array("earth","solar"),"218"=>array("mirror","planetary"),"219"=>array("storm","spectral"),"220"=>array("sun","crystal"),
    
    "221"=>array("dragon","cosmic"),"222"=>array("wind","magnetic"),"223"=>array("night","lunar"),"224"=>array("seed","electric"),"225"=>array("snake","selfexisting"),
    "226"=>array("worldBridger","overtone"),"227"=>array("hand","rhythmic"),"228"=>array("star","resonant"),"229"=>array("moon","galactic"),
    "230"=>array("dog","solar"),"231"=>array("monkey","planetary"),"232"=>array("human","spectral"),"233"=>array("skyWalker","crystal"),
    "234"=>array("wizard","cosmic"),"235"=>array("eagle","magnetic"),"236"=>array("warrior","lunar"),"237"=>array("earth","electric"),"238"=>array("mirror","selfexisting"),
    "239"=>array("storm","overtone"),"240"=>array("sun","rhythmic"),
    
    "241"=>array("dragon","resonant"),"242"=>array("wind","galactic"),"243"=>array("night","solar"),"244"=>array("seed","planetary"),"245"=>array("snake","spectral"),"246"=>array("worldBridger","crystal"),
    "247"=>array("hand","cosmic"),"248"=>array("star","magnetic"),"249"=>array("moon","lunar"),"250"=>array("dog","electric"),"251"=>array("monkey","selfexisting"),
    "252"=>array("human","overtone"),"253"=>array("skyWalker","rhythmic"),"254"=>array("wizard","resonant"),"255"=>array("eagle","galactic"),
    "256"=>array("warrior","solar"),"257"=>array("earth","planetary"),"258"=>array("mirror","spectral"),"259"=>array("storm","crystal"),
    "260"=>array("sun","cosmic")
    
    );    
private $bdate_z;
private $btime_z;
public $my_result;
public $my_result_display;

public $kin_seal;
public $kin_tone;
public $kin_number;
public $guide_seal;
public $guide_tone;

public $analogue_seal;
public $analogue_tone;

public $antipode_seal;
public $antipode_tone;

public $occult_seal;
public $occult_tone;


public $BirthtimeUnknown;

public $tribe;
public $a_tribe;

private  $my_row_data;


private $timezone;

public function __construct($row){
    
	$bdate=$row['day']."-".$row['month']."-".$row['year'];



	$this->timezone=$row['timezone_txt'];
		
		//Time is known
		if($row['unknowntime']!=1){

		$this->btime_z=$row['hour'].":".$row['minute'];
		
		$this->BirthtimeUnknown=FALSE;
		
	
		}	
		//Time is Unknown
		else {
			
		$bhour='NULL';
		$this->BirthtimeUnknown=TRUE;
		$this->btime_z="12:00";
		
		};





	//$bhour=$row['hour'].":".$row['minute'];
    $this->bdate_z=$bdate;
  //  $this->btime_z=$bhour;

    $this->my_result=$this->castle_result();
    $this->kin_seal=$this->my_result->kin_seal;

    $this->kin_tone=$this->my_result->kin_tone;
    $this->kin_number=$this->my_result->kin_number;

    $this->guide_seal=$this->my_result->guide_seal;
    $this->guide_tone=$this->my_result->guide_tone;

    $this->analogue_seal=$this->my_result->analogue_seal;
    $this->analogue_tone=$this->my_result->analogue_tone;

    $this->antipode_seal=$this->my_result->antipode_seal;
    $this->antipode_tone=$this->my_result->antipode_tone;

    $this->occult_seal=$this->my_result->occult_seal;
    $this->occult_tone=$this->my_result->occult_tone;

    $this->tribe=$this->my_result->tribe;
    $this->a_tribe=$this->my_result->a_tribe;

    $this->my_result_display=$this->set_my_result_display();

    $this->setMy_Row();

}

function kin_260_prober($total) {
    while ($total > 260) {
        $total -= 260;
    }
    return $total;
}
private function castle_result()
{

        //$my_result=new stdClass();

        $bdate_e=$this->bdate_z." ".$this->btime_z;

        $Dateformat = "d-m-Y H:i";

        //$date = DateTime::createFromFormat($Dateformat, $bdate_e);
        //$date =Time:: createFromTime((int)$this->btime_z);
        $date =Time ::createFromFormat($Dateformat,$bdate_e);

        $isleap=$this->is_leap($date);
        $leapday=$this->leapday($isleap,$date);
        $leap=intval($leapday);

        $yearbr=$this->find_year_mumber(date_format($date,"Y"));
        $nbr=$this->find_month_number(date_format($date,"m"));
        $total=$leap+$yearbr+$nbr;
        
        //kin nbr index 
        //Correct when $total> n*260 
      //  $kin_index=$total>260?$total-260:$total;
     
       //
       
         $kin_index=$this->kin_260_prober($total);

        /*Calculate kin*/
       // $result=$this->obtain_kin($kin_index,$this->tzolkin);

        $result= $this->tzolkin[$kin_index];

        $kin=$result;
        /*Tell tribe*/
       
        //var_dump($tribe);

        /*get the number for the text version of kin*/
        $kin_num=$this->get_toneSeal_numb($kin[0],$kin[1]);
        array_push($kin,$kin_index);

        /*Calculate guide*/
        $guide=$this->guide($kin_num[0],$kin_num[1]);
        $guide_nbr=$this->get_index_from_tone_seal($guide[0],$guide[1]);
        $guide=$this->tzolkin[$guide_nbr];

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



      
        $tribe=$this->tribe($kin[0]);
        $a_tribe=$this->tribe($analogue[0]);
        //echo "occult : ".$occult[0]." ".$occult[1];
        //$my_result->occult=$occult;
        ###########################################";

        $castle_result=$this->castle($kin,$guide,$analogue,$antipode,$occult,$tribe,$a_tribe);
            
        return $castle_result; /*returns arrays of each result*/

}


private function find_year_mumber($year){

    $year_numb=array("1920"=>72,"1921"=>177,"1922"=>22,"1923"=>127,"1924"=>23,"1925"=>77,"1926"=>182,"1927"=>27,"1928"=>132,"1929"=>237,
    "1930"=>82,"1931"=>187,"1932"=>32,"1933"=>137,"1934"=>242,"1935"=>87,"1936"=>192,"1937"=>37,"1938"=>142,"1939"=>247,"1940"=>92,"1941"=>197,
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

private function find_month_number($month){  
    
    $month_numb=array(0,31,59,90,120,151,181,212,243,13,44,74);    
    $month_r=$month_numb[$month-1];      
    return $month_r;
}

/* Return  numeric index position in the tzolkin array*/
public function get_index_from_tone_seal($seal_i,$tone_i){
    
    $index=0;
    $seal=$seal_i;
    $tone=$tone_i;    
    $array=$this->tzolkin;
    
    if (!is_array($array)) 

        return FALSE;
    
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
                $tone="resonant";
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

                    }
                    
        
        
            }
    
   
    
    
                        /* returns kin numeric index position in the
                        tzolkin array*/
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
    $guide[1]= $tone;
    
    
    switch ($tone){
  
     case 1:
     $guide[0] = $seal;
     break;
 
     case 2:
     $guide[0] = $seal + 12;
                  If( $guide[0]>260)
                  {
     $guide[0] =$seal-8;
                  }
     break;               
         
     case 3:
     $guide[0]= $seal+4;
                  If( $guide[0]>260)
                   {
     $guide[0]=$seal-16;
                   }
     break;
      case 4:
     $guide[0]= $seal+16;
       
         If( $guide[0]>260)
                   {
     $guide[0]=$seal-4;
                   }
     break;
        case 5:
     $guide[0]= $seal+8;
        
              If( $guide[0]>260)
                   {
     $guide[0]=$seal-12;
                   }
     break;
     case 6:
     $guide[0] = $seal;
     break;
     case 7:
     $guide[0] = $seal + 12;
                  If( $guide[0]>260)
                  {
     $guide[0] =$seal-8;
                  }
     break;
 
     case 8:
     $guide[0]= $seal+4;
                 If( $guide[0]>260)
                   {
     $guide[0]=$seal-16;
                   }
     break;
        
     case 9:
     $guide[0]= $seal+16;
             If( $guide[0]>260)
                   {
     $guide[0]=$seal-4;
                   }
     break;   
        
     case 10:
     $guide[0]= $seal+8; 
     
       If( $guide[0]>260)
                   {
     $guide[0]=$seal-12;
                   }
     break;
     case 11:
     $guide[0] = $seal;
     break;
     case 12:
     $guide[0]= $seal + 12;
                  If( $guide[0]>260)
                  {
     $guide[0]=$seal-8;
                  }
     break; 
     case 13:
     $guide[0]= $seal+4;
             If( $guide[0]>260)
                   {
     $guide[0]=$seal-16;    
                   }
     break;                 
              
     }
     
     if ($guide[0]>20){$guide[0]-=20;
        return $guide; 
    }
     if ($guide[0]<0){$guide[0]+=20;   
         return $guide;
        
        }    
        return $guide;
     
 }
/*Caculates analogue seal */
private function analogue($seal,$tone){
    
    //$analogue=array($seal-5,$tone);
    $s=19-$seal;
    if($s==0)$s=20;
    if($s==-1)$s=19;
    $analogue=array($s,$tone);
        return $analogue;
}
/*Caculates antipode seal */
private function antipode($seal,$tone){
    $s=$seal+10 ;
    if($s>20){$s=$s-20;}

    $antipode=array($s,$tone);
    return $antipode;
    
}
/*Caculates occult seal */
private function occult($seal,$tone){
    $s=21-$seal;
    $t=14-$tone;
    $occult=array($s,$t);
    return $occult;
    
}
private function castle($kin_a,$guide_a,$analogue_a,$antipode_a,$occult_a,$tibe_a,$a_tribe){  
    
    $castle_r= (Object)[];
    
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
    $castle_r->a_tribe=$a_tribe;
    //  $castle_r->occult_numb= $occult_a[2];
   
  return $castle_r;
    
}



private function tribe($seal){

            
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





//Return 1 if its leap year
public function is_leap($date_r){
    
    $leap = 0; //Leap is false as default
           
       $year= date_format($date_r,"Y");       
       $leap = date('L', mktime(0, 0, 0, 1, 1, $year));
       
   return $leap;
       
       //echo $year . ' ' . ($leap ? 'is' : 'is not') . ' a leap year.';

}
/*returns 28 if its 29 feb but before noon or 1 if its after noon . returns the same day if its not this date*/
public function leapday($flag,$date){
   
        $day= date_format($date,"d");
        $month= date_format($date,"m"); 
        $hour=date_format($date,"H"); 
        
           if ($flag) {
                   
                           if ($month==2){
                               
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
                                else{ //if its not 29 of february
                                    
                                    return $day;
                                
                                }
                   }               
               else {return $day;}
   return $day;
}

private function set_my_result_display(){ 
    $my_result_display = '<div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>KIN TONE</th>
                            <th>KIN SEAL</th>
                            <th>KIN NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$this->my_result->kin_tone.'</td>
                            <td>'.$this->my_result->kin_seal.'</td>
                            <td>'.$this->my_result->kin_number.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>GUIDE TONE</th>
                            <th>GUIDE SEAL</th>
                            <th>ANALOGUE TONE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$this->my_result->guide_tone.'</td>
                            <td>'.$this->my_result->guide_seal.'</td>
                            <td>'.$this->my_result->analogue_tone.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ANALOGUE SEAL</th>
                            <th>ANTIPODE TONE</th>
                            <th>ANTIPODE SEAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$this->my_result->analogue_seal.'</td>
                            <td>'.$this->my_result->antipode_tone.'</td>
                            <td>'.$this->my_result->antipode_seal.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>OCCULT TONE</th>
                            <th>OCCULT SEAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$this->my_result->occult_tone.'</td>
                            <td>'.$this->my_result->occult_seal.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>';

    return $my_result_display;
}


public function get_my_profile(){

    return $this->my_result;

}

public function get_my_result_display(){
 
 return( $this->my_result_display);
}




private function setMy_Row(){
	$this->my_row_data=[        

		'kin_tone'=> $this->my_result->kin_tone,
		'kin_seal'=> $this->my_result->kin_seal,
		'kin_number'=> $this->my_result->kin_number,
        'guide_seal'=>$this->my_result->guide_seal,
        'guide_tone'=>$this->my_result->guide_tone,
        'analogue_seal'=>$this->my_result->analogue_seal,
        'analogue_tone'=>$this->my_result->analogue_tone,
        'antipode_seal'=>$this->my_result->antipode_seal,
        'antipode_tone'=>$this->my_result->antipode_tone,
        'occult_seal'=>$this->my_result->occult_seal,
        'occult_tone'=>$this->my_result->occult_tone,
        'tribe'=>$this->my_result->tribe,	
        'a_tribe'=>$this->my_result->a_tribe	

		];

}
public function  getMy_Row(){

	return $this->my_row_data;


}

public function export_for_match(){
  
 return $this->my_result; /*returns arrays of each result*/
    
}

}// end of class May
