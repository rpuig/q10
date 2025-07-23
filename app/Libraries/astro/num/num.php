<?php
class Num{


private $name;
private $surname;
private $full_name;
private $destiny_number;
private $destiny_number_full;
private $soul_number;
private $life_path;
private $life_path_number_group;

private $nums_table=array (  array("a",1),  array("b",2),  array("c",3),  array("d",4),  array("e",5),  array("f",6),  array("g",7),
  array("h",8),  array("i",9),  array("j",1),  array("k",2),  array("l",3),  array("m",4),  array("n",5),array("ñ",5),
  array("o",6),  array("p",7),  array("q",8),  array("r",9),  array("s",1),  array("t",2),  array("u",3),
  array("v",4),  array("w",5),  array("x",6),  array("y",7),  array("z",8) );



public function __construct($name,$surname, $bdate){

	$this->name=$name;
	$this->surname=$surname;
	$this->full_name=$this->fullname($name,$surname);
	$this->destiny_number=$this->destiny_number($name);
	$this->destiny_number_full=$this->destiny_number_full($this->full_name);
	$this->soul_number=$this->soul_number($name);
	$this->life_path=$this->life_path($bdate);
	$this->life_path_number_group=$this->life_path_number_group($this->life_path);
	}
/*Expression aka destiny number*/
private function destiny_number($string_name="name"){
	$nums_table=$this->nums_table;
	$result = (object) [    'name' => 'name',    'destiny_number' => 0];
  
 	$string_name=strtolower(preg_replace('/\s+/', '', $string_name));
	
	$life_path=0;	
	$length=strlen($string_name);
	$temp_str="";
		for($i=0;$i<$length;$i++)
		
		{
			$temp_str=$string_name[$i]; //Letter to check;
				for  ($k=0;$k<count($nums_table);$k++)
                                                                      {
                                    /*We compare the letter to all possible inside the nums list*/
				$temp_str2=$nums_table[$k][0];
				if ($temp_str==$temp_str2)
					{
						$life_path+=$nums_table[$k][1];
                                                                                                break;
                                                        
					}		
                                                        }		
		}
	
			$sum=0;
			
				$result->destiny_number=$this->reduce($life_path);
				$result->name=$string_name;
	
	return $result;
}

private function destiny_number_full($string_name="name",$string_surname="surname"){
	$nums_table=$this->nums_table;
	$result = (object) [    'name' => 'name', 'surname' => 'surname',   'destiny_number' => 0,
  ];
  
 	$string_name=strtolower(preg_replace('/\s+/', '', $string_name.$string_surname));
	
	$life_path=0;	
	$length=strlen($string_name);
	$temp_str="";
		for($i=0;$i<$length;$i++)
		
		{
			$temp_str=$string_name[$i]; //Letter to check;
				for  ($k=0;$k<count($nums_table);$k++)
                                                                      {
                                    /*We compare the letter to all possible inside the nums list*/
				$temp_str2=$nums_table[$k][0];
				
				
				if ($temp_str==$temp_str2)
					{
						$life_path+=$nums_table[$k][1];
                                                                                                        break;
                                                        
					}		
				
                                                                       }			
			
		}
	
			$sum=0;
			
				$result->destiny_number=$this->reduce($life_path);
				$result->name=$string_name;
				$result->surname=$string_surname;
	
	return $result;
}
/* Soul number*/
private function soul_number($string_name="name"){ 
	$nums_table=$this->nums_table;
	
	$result = (object) [    'name' => 'name',    'SoulNumber' => 0,];
  
 	$string_name=preg_replace('/\s+/', '', $string_name);
	$string_name=strtolower($string_name);
	//print_r($string_name);
	$life_path=0;	
	$length=strlen($string_name);
	$temp_str="";
		for($i=0;$i<$length;$i++)
		
		{
			$temp_str=$string_name[$i]; //Letter to check;
				for  ($k=0;$k<26;$k++){/*We compare the letter to all possible inside the nums list*/
				$temp_str2=$nums_table[$k][0];
				if ($temp_str==$temp_str2)
					if ($temp_str2=="a" or $temp_str2=="e"  or $temp_str2=="i" or $temp_str2=="o" or $temp_str2=="u" )
			
					{
						$life_path+=$nums_table[$k][1];
					
					}		
				
			}			
			
		}
	
			$sum=0;
			//$returnThis=sumDigits($life_path,10);
				$result->SoulNumber=$this->reduce($life_path);
				$result->name=$string_name;
	
	return $result;	
	
}

private function fullname($name,$surname){
return $name.$surname;	
	
	
}

/*Life path number*/
private function life_path($date_birth){
	
	$date = str_replace('/', '', $date_birth);
	
	$sum=$this->sumDigits_life_path($date);
	$sum=$this->reduce($sum);

return $sum;
	
}

/*Life path number group*/
private function life_path_number_group($number){
	
	switch($number){
		
                case 1:		$group='mind';  	break;	
                case 5:		$group='mind';		break;	
                case 7:		$group='mind';		break;
                
                case 3:		$group='creative';	break;	
                case 6:		$group='creative';	break;	
                case 9:		$group='creative';	break;
                
                case 2:		$group='business';	break;	
                case 4:		$group='business';	break;	
                case 8:		$group='business';	break;
                
                case 33:	$group='business';	break;		
                case 11:	$group='business';	break;
                case 22:	$group='business';	break;	
		
		
	}
	
	return 	$group;	
	
}
###########################################################
private function sumDigits($num, $base = 10) {
    $result=0;
	$s = base_convert($num, 10, $base);
    foreach (str_split($s) as $c)
        $result += intval($c, $base);
    return $result;
}

private function sumDigits_life_path($num, $base = 10) {
   	$result = (object) [    'day' => 0,    'month' => 0,	'year'=>0,  ];
   
	/* $s = base_convert($num, 10, $base);
	$str=str_split($s); */
	
	$date_elements=array(3);
	$date_elements[0]=array($num[0].$num[1]);
	$date_elements[1]=array($num[2].$num[3]);
	$date_elements[2]=array($num[4].$num[5].$num[6].$num[7]);
	
    foreach (  $date_elements[0] as $c){
		
		$result->day+= intval($c, $base);		
				}
	 foreach (  $date_elements[1] as $c){		
        $result->month+= intval($c, $base);
				}			
	 foreach (  $date_elements[2] as $c){		
        $result->year+= intval($c, $base);
				}	

$result->day=(int)$this->reduce($result->day);
$result->month=(int)$this->reduce($result->month);
$result->year= (int)$this->reduce($result->year);
$result2=$result->day+$result->month+$result->year;
    return $result2;
}

private function reduce($number) {
    $new_number = 0;
    if($number < 10) {
        return $number;
    }           
    if($number == 11 or $number == 22 or $number == 33) {
        return $number;
    }
	 
    $q = floor($number / 10 );
    $r = $number % 10;
    $new_number = $q + $r;

    if($new_number <= 9) {          
        return $new_number;         
    }
    else {
        reduce($new_number);
    }
return reduce($new_number);
}

private function initial_group($name){
$name_i=$name[0];
$type="0";
$ini_array=array("a"=>1,"c"=>1,"e"=>1,"g"=>1,"i"=>1,"k"=>1,"m"=>1,"o"=>1,"q"=>1,"s"=>1,"u"=>1,"w"=>1,"y"=>1,
"b"=>2,"d"=>2,"f"=>2,"h"=>2,"j"=>2,"l"=>2,"n"=>2,"p"=>2,"r"=>2,"t"=>2,"v"=>2,"x"=>2,"z"=>2);


	switch( $name_i){
		
		
		case "a": $type="1"; break;
		case "c": $type="1"; break;
		case "e": $type="1"; break;
		case "g": $type="1"; break;
		case "i": $type="1"; break;
		case "k": $type="1"; break;
		case "m": $type="1"; break;
		case "o": $type="1"; break;
		case "q": $type="1"; break;
		case "s": $type="1"; break;
		case "u": $type="1"; break;
		case "w": $type="1"; break;
		case "y": $type="1"; break;
		
		case "b": $type="2"; break;
		case "d": $type="2"; break;
		case "f": $type="2"; break;
		case "h": $type="2"; break;
		case "j": $type="2"; break;
		case "l": $type="2"; break;
		case "n": $type="2"; break;
		case "p": $type="2"; break;
		case "r": $type="2"; break;
		case "t": $type="2"; break;
		case "v": $type="2"; break;
		case "x": $type="2"; break;
		case "z": $type="2"; break;		
		
		
	}

return $type;
	
}


/*NUM Get Readings from file*/
function file_contents($path){

	$file=0;
	switch ($path) {
		case 1:
		$file=1;
		break;
		case 2:
		$file=2;
		break;
		case 3:
		$file=3;
		break;	
		
		case 4:
		$file=4;
		break;
		case 5:
	$file=5;
		break;
		case 6:
		$file=6;
		case 7:
		$file=7;
		break;
		case 8:
	$file=8;
		break;
		case 9:
		$file=9;
		break;
		case 11:
		$file=11;
		break;
		case 22:
		$file=22;
		break;
		case 33:
		$file=33;
		break;	
		case 'mind':
		$file="mind";
		break;
		case 'business':
		$file="business";
		break;
		case 'creative':
		$file="creative";
		break;	
		case "Soul 1":
		$file="Soul 1";
		break;
		case "Soul 2":
		$file="Soul 2";
		break;
		case "Soul 3":
		$file="Soul 3";
		break;
		case "Soul 4":
		$file="Soul 4";
		break;
		case "Soul 5":
		$file="Soul 5";
		break;
		case "Soul 6":
		$file="Soul 6";
		break;	
		case "Soul 7":
		$file="Soul 7";
		break;
		case "Soul 8":
		$file="Soul 8";
		break;
		case "Soul 9":
		$file="Soul 9";
		break;	
		case "Life 1":
		$file="Life 1";
		break;
		case "Life 2":
		$file="Life 2";
		break;
		case "Life 3":
		$file="Life 3";
		break;
		case "Life 4":
		$file="Life 4";
		break;
		case "Life 5":
		$file="Life 5";
		break;
		case "Life 6":
		$file="Life 6";
		break;	
		case "Life 7":
		$file="Life 7";
		break;
		case "Life 8":
		$file="Life 8";
		break;
		case "Life 9":
		$file="Life 9";
		break;	
	}

	$path2="numbers/".$path.".txt";

					return open_file($path2);
	}
/*NUM prepare for reverse engineer ***/
function prepare_num_results_reverse_eng($names_list,$nums_table)
{
	$all_result_list=[];/*contains all results*/	
	$all_result=(object)['bd1'=>'01/01/2011','tb1'=>'12:00','bd2'=>'01/01/2011','tb2'=>'12:00','score'=>0];
	
	foreach($names_list as $valor){		
	   
		$bd1=$valor[0];		
		$all_result->bd1=$bd1;
		$tb1=$valor[1];		
		$all_result->tb1=$tb1;
		
		$bd2=$valor[2];		
		$all_result->bd2=$bd2;
		$tb2=$valor[3];		
		$all_result->tb2=$tb2;
		
		$score=$valor[4];	
		$all_result->score=$score;
		
		array_push($all_result_list,(Array)$all_result);
	}
	return $all_result_list;/*This stores each person with the results per person*/	
}
/*NUM Get calculated numerology of a name from  csv*/
function prepare_num_results($names_list,$nums_table)
{
	$all_result_list=[];/*contains all results*/	
	$all_result=(object)['name'=>'name','surname'=>'surname','destiny_number'=>0,'soul_number'=>0,'life_path'=>0,'life_path_group'=>'unset',
	'birthdate'=>'birthdate','timebirth'=>'timebirth',];
	foreach($names_list as $valor){			   
		$name=$valor[0];		
		$all_result->name=$name;		
		$surname_var=$valor[1];		
		$all_result->surname=$surname_var;		
		$result=destiny_number( $name,$nums_table);		
		$all_result->destiny_number=$result->destiny_number;		
		$result=soul_number($nums_table, $name);
		$all_result->soul_number=$result->SoulNumber;		
		$result=life_path($valor[2]);
		$all_result->life_path=$result;		
		$result=life_path_number_group($result);		
		$all_result->life_path_group=$result;/*BUG not registering string business into all result*/
		$birthdate=$valor[2];
		$all_result->birthdate=$birthdate;		
		$timeObirth=$valor[3];		
		$all_result->timebirth=$timeObirth;		
		array_push($all_result_list,(Array)$all_result);
		}
		return $all_result_list;/*This stores each person with the results per person*/	
}


function display_num($names_list,$nums_table)
	{

	echo "<table align=center width=\"80%\">";
	echo "<tr>";
	echo "<td ><h2>Name</h1></td>";
	echo "<td class=\"lp\"><h2>Destiny number</h1></td>";
	echo "<td class=\"dn\"><h2>Soul Number</h1></td>";
	echo "<td class=\"dn\"><h2>Life Path Number</h1></td>";
	echo "<td class=\"dn\"><h2>Life path Number group</h1></td>";


	foreach($names_list as $valor){	
	
		$result=destiny_number($nums_table, $valor[0]);	
		echo "<tr class=\"dn\">";
		echo "<td>";
		echo "<br>"."<b>".$result->name."</b>";
		echo "</td>";
		
        echo "<td>";  		
		echo $result->destiny_number;
		
		echo "<p>". nl2br($this->file_contents($result->destiny_number))."<p>";
		echo "</td>";
		
		echo "<td>";		
		$result=soul_number($nums_table,$valor[0]);
		echo "<b>".$result->SoulNumber."</b>"."<br>";
		echo "<p>". nl2br($this->file_contents("Soul ".$result->SoulNumber ))."<p>";
		echo "</td>";
		
		echo "<td>";		
		echo $result=life_path($valor[1]);
		echo "<p>". nl2br($this->file_contents("Life ".$result))."<p>";
		echo "</td>";	
		
		echo "<td>";		
		echo "<b>".strtoupper(life_path_number_group ($result))."</b>";
		echo "<p>". nl2br($this->file_contents(life_path_number_group($result)))."<p>";
		echo "</td>";
		
		}
	
	
		echo "</table>";
	}

}//End of class Num