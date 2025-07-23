
<?php
$nums_table=array (  array("a",1),  array("b",2),  array("c",3),  array("d",4),  array("e",5),  array("f",6),  array("g",7),
  array("h",8),  array("i",9),  array("j",1),  array("k",2),  array("l",3),  array("m",4),  array("n",5),array("ñ",5),
  array("o",6),  array("p",7),  array("q",8),  array("r",9),  array("s",1),  array("t",2),  array("u",3),
  array("v",4),  array("w",5),  array("x",6),  array("y",7),  array("z",8) );

/*Expression aka destiny number*/
function destiny_number($string_name2="full name",$nums_table){
	$result = (object) [    'name' => 'name',    'destiny_number' => 0,
  ];
  
 	$string_name=strtolower(preg_replace('/\s+/', '', $string_name2));
	
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
			
				$result->destiny_number=reduce($life_path);
				$result->name=$string_name2;
	
	return $result;
}

function destiny_number_full($string_name="name",$string_surname="surname",$nums_table){
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
			
				$result->destiny_number=reduce($life_path);
				$result->name=$string_name;
				$result->surname=$string_surname;
	
	return $result;
}
/* Soul number*/
function soul_number($string_name2="full name",$nums_table){ 
	$result = (object) [    'name' => 'name',    'SoulNumber' => 0,
  ];
  
 	$string_name=preg_replace('/\s+/', '', $string_name2);
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
				$result->SoulNumber=reduce($life_path);
				$result->name=$string_name2;
	
	return $result;	
	
}

function fullname($name,$surnme){
return $name.$surname;	
	
	
}

/*Life path number*/
function life_path($date_birth){
	
	$date = str_replace('/', '', $date_birth);
	
	$sum=sumDigits_life_path($date);
	$sum=reduce($sum);

return $sum;
	
}

/*Life path number group*/
function life_path_number_group($number){
	
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
function sumDigits($num, $base = 10) {
    $result=0;
	$s = base_convert($num, 10, $base);
    foreach (str_split($s) as $c)
        $result += intval($c, $base);
    return $result;
}

function sumDigits_life_path($num, $base = 10) {
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

$result->day=(int)reduce($result->day);
$result->month=(int)reduce($result->month);
$result->year= (int)reduce($result->year);
$result2=$result->day+$result->month+$result->year;
    return $result2;
}

function reduce($number) {
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

function initial_group($name){
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
