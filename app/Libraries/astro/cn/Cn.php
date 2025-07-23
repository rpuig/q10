<?php


namespace app\Libraries\astro\cn;
use App\Controllers\BaseController;
include_once 'cn_constants.php';
//include $_SERVER['DOCUMENT_ROOT'].'/q10/constants.php';

require_once(__DIR__ . '/../data_export/csv-extract.php');




Class Cn extends BaseController{
/*10 HEAVENLY STEMS*/

private $pathCSV;
private $HSIA;

public $cn_result;
private $cn_result_display;
private $cn_5el_display;
private $el_level;

private $el_profile;
private $yin_level;
private $yang_level;

private $BirthtimeUnknown;


private $cn_row_data;

public function __construct($row){


    $bdate=$row['day']."-".$row['month']."-".$row['year'];
		$timezone=$row['timezone_txt'];
		
		//Time is known
		if($row['unknowntime']!=1){

		$bhour=$row['hour'].":".$row['minute'];
		
		$this->BirthtimeUnknown=FALSE;
		
	
		}	
		//Time is Unknown
		else 	{
			
		$bhour='NULL';
		$this->BirthtimeUnknown=TRUE;
		
		
		};

		
		
		$this->pathCSV= __DIR__ ."/master.csv";
		$this->HSIA= get_csv($this->pathCSV);		
		$this->cn_result=$this->set_cn_profile($bhour,$bdate,$timezone);
		$this->set_Cn_Row();
		
		
		$this->cn_result_display=$this->set_cn_result_display($this->cn_result);
		
}




private function search_values($array,$Year,$Month,$Day){	
	$result = (object) ['SN' => "s/n",'HS_Year' => 0,'EB_Year' => 0,'HS_Month' => 0,'EB_Month' => 0,'HS_Day' => 0,'EB_Day' => 0,'Season' => 0,
  ];
	for ($i=0;$i<count($array);$i++){
		if (($array[$i]['Year']==$Year)&&($array[$i]['Month']==$Month)&&($array[$i]['Day']==$Day)){
			
		
		$result->SN=$array[$i]['S/N'];		
		$result->HS_Year=$array[$i]['HS of Year'];
		$result->EB_Year=$array[$i]['EB of Year'];
		$result->HS_Month=$array[$i]['HS of Month'];
		$result->EB_Month=$array[$i]['EB of Month'];
		$result->HS_Day=$array[$i]['HS of Day'];
		$result->EB_Day=$array[$i]['EB of Day'];
		$result->Season=$array[$i]['Season'];
		break;
		
		}
		else{
		$error="not found";
		$result->SN=$error;	
		$result->HS_Year=$error;
		$result->EB_Year=$error;
		$result->EB_Month=$error;
		$result->HS_Month=$error;
		$result->HS_Day=$error;
		$result->EB_Day=$error;
		$result->Season=$error;
		
		}
	}
	return $result;
}
private function get_pilar_image($pillar,$type,$twelve_earthly_branches_phase_names="",$twelve_earthly_branches_eng_names=""){

	if ($type=="HS"){

		if ($pillar=="N/A"){	
		
			$image_url="NA.gif";
		
			}
			else{
			$image_url=$pillar.".gif";
			

			}	
			
			$url='/HS/'.$image_url;
	}


	else{


		
		
		if ($pillar=="N/A"){	
		
		$image_url="NA.gif";
		}
		else{
		$index = array_search($pillar, twelve_earthly_branches_eng_names);	
		$image_url=$twelve_earthly_branches_eng_names[$index].".gif";

		}


		$url='/EB/'.$image_url;

	}
	
	$link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$e_link = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
	$html = '<img src="' . base_url('assets/images/cn' . $url) . '" alt="ERROR ' . $image_url . '">';

	//echo ($html);

	return $html;
}





private function find_Year_stem_nbr($year){
	$stem=($year-3)% 10;
	return $stem;
	}
private function find_month_stem($month,$heavenly_stem_fbr_nbr){
	$j=$month-1;
	$m=1;
	$stem=$heavenly_stem_fbr_nbr; 	
	$i=$stem;
	 	while($m<$j) /*months loop*/
		{			
					
					$stem++;															
					$m++;
					if ($stem>10){$stem=1;}				
		}
		

return $stem;
}
private function find_February_heaven_stem_nbr($heavenly_stem_year){
if (($heavenly_stem_year==1) or ($heavenly_stem_year==6)){
  $feb_stem=3;
  }
  if (($heavenly_stem_year==2) or ($heavenly_stem_year==7)){
  $feb_stem=5;
  }
  else if (($heavenly_stem_year==3) or ($heavenly_stem_year==8))
  {
  $feb_stem=7;
  }
  else if (($heavenly_stem_year==4) or ($heavenly_stem_year==9))
  {
  $feb_stem=9;
  }
  else if (($heavenly_stem_year==5) or ($heavenly_stem_year==10))
  {
  $feb_stem=1;
  }
  else
  {$feb_stem=0;}//Error in entered value
return $feb_stem;
}
private function find_year_branch_nbr($year){
	
	
	$mod=$year % 100;
	if ($mod>12){
		$mod=($mod%12)+1;
		
	}
	if ($mod==0){$mod++;}
	
return ($mod);
}
private function find_hour_branch_nbr($time){
	
	if ((strtotime($time) >= strtotime('00:00'))&&(strtotime($time) < strtotime('01:00'))){
				return 1;
	}
    if ((strtotime($time)>= strtotime('01:00'))&&(strtotime($time) < strtotime('03:00'))){
				return 2;
	}
	if ((strtotime($time)>= strtotime('03:00'))&&(strtotime($time) < strtotime('05:00'))){
				return 3;
	}
	if ((strtotime($time) >=strtotime('05:00'))&&(strtotime($time) < strtotime('07:00'))){
				return 4;
	}
	if ((strtotime($time) >=strtotime('07:00'))&&(strtotime($time) < strtotime('09:00'))){
				return 5;
	}
	if ((strtotime($time)>= strtotime('09:00'))&&(strtotime($time) < strtotime('11:00'))){
				return 6;
	}
	if ((strtotime($time)>= strtotime('11:00'))&&(strtotime($time) < strtotime('13:00'))){
				return 7;
	}
	if ((strtotime($time) >=strtotime('13:00'))&&(strtotime($time) < strtotime('15:00'))){
				return 8;
	}
	if ((strtotime($time) >=strtotime('15:00'))&&(strtotime($time) < strtotime('17:00'))){
				return 9;
	}
	if ((strtotime($time)>= strtotime('17:00'))&&(strtotime($time) < strtotime('19:00'))){
				return 10;
	}
	if ((strtotime($time)>= strtotime('19:00'))&&(strtotime($time) < strtotime('21:00'))){
				return 11;
	}	
	if ((strtotime($time)>= strtotime('21:00'))&&(strtotime($time) < strtotime('23:00'))){
				return 12;
	}
	if ((strtotime($time)>= strtotime('23:00'))&&(strtotime($time) <= strtotime('23:59'))){
				return 1;
	}
        
return 1;
}
private function find_hour_stem_nbr($time,$early_hour_rat_stem_nbr){
/*1=>"jia",2=>"Yi",3=>"Bing",4=>"Ding",5=>"Wu",6=>"Ji",7=>"Geng",8=>"Xin",9=>"Ren",10=>"Gui"*/


	$temp=-2;	
	$hour_stem_nbr=0;
	$temp=$temp+$early_hour_rat_stem_nbr;
	
	if ((strtotime($time) >= strtotime('00:00'))&&(strtotime($time) <= strtotime('0:59'))){
				
				/* Late Rat hour  Zi*/
				$temp+=0;			
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
    if ((strtotime($time) >= strtotime('01:00'))&&(strtotime($time)<=  strtotime('02:59'))){
				/* Ox  hour Chou*/
				$temp+=1;			
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('03:00'))&&(strtotime($time)<= strtotime('04:59'))){
				 /* Tiger hour  Yin*/
				$temp+=2;				
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('05:00'))&&(strtotime($time)  <= strtotime('06:59'))){
				 /* Rabbit hour  Mao*/
				$temp+=3;	
								
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('07:00'))&&(strtotime($time)<= strtotime('08:59'))){
				/*  Dragon hour Chen */
				$temp+=4;	
								
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('09:00'))&&(strtotime($time)  <= strtotime('10:59'))){
				 /* Snake hour  Si*/
				$temp+=5;					
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('11:00'))&&(strtotime($time)<= strtotime('12:59'))){
				 /* Horse hour  Wu*/
				$temp+=6;					
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('13:00'))&&(strtotime($time)  <= strtotime('14:59'))){
				 /* Goat hour Wei*/
				$temp+=7;					
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time) >= strtotime('15:00'))&&(strtotime($time) <=  strtotime('16:59'))){
				 /* Monkey hour  Shen*/
				$temp+=8;					
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time) >= strtotime('17:00'))&&(strtotime($time) <=  strtotime('18:59'))){
				  /* Rooster hour You*/	
				$temp+=9;				
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time) >= strtotime('19:00'))&&(strtotime($time)<=  strtotime('20:59'))){
				  /* Dog hour  Xu*/		
				$temp+=10;				
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}	
	if ((strtotime($time)>=  strtotime('21:00'))&&(strtotime($time)  <= strtotime('22:59'))){
				  /* Pig hour  Hai*/	
				$temp+=11;					
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	if ((strtotime($time)>=  strtotime('23:00'))&&(strtotime($time) <=  strtotime('23:59'))){
				  /* Early rat hour Zi*/
				$temp+=0;				
				
				/*Check if over 10 */
				if ($temp<=10)
				{$hour_stem_nbr=$temp;}
				
				else{
				$hour_stem_nbr=$temp-10;
				$hour_stem_nbr+=0;
				}
	}
	
	
	return $hour_stem_nbr;
	
}
/*Calculate early rat hour based on day stem number*/
/*We need to find the stem number for the rat hour on that day*/

private function find_early_hour_rat_stem_nbr($day_stem){
	/* 1=>"jia",2=>"Yi",
3=>"Bing",4=>"Ding",5=>"Wu",6=>"Ji",7=>"Geng",8=>"Xin",9=>"Ren",10=>"Gui" */

	$early_rat_hour_stem=0;
	
	
	switch ($day_stem){
	
	case 1:$early_rat_hour_stem=1;	/* Returns jia*/
	case 6:$early_rat_hour_stem=1;
	
	case 2:$early_rat_hour_stem=3;	/*Returns Bing*/
	case 7:$early_rat_hour_stem=3;
	
	case 3:$early_rat_hour_stem=5;	/* Returns Wu*/
	case 8:$early_rat_hour_stem=5;
	
	case 4:$early_rat_hour_stem=7;	/*Returns Geng*/
	case 9:$early_rat_hour_stem=7;	
	
	case 5:$early_rat_hour_stem=9;	/* Returns Ren*/
	case 10:$early_rat_hour_stem=9;
	}
return $early_rat_hour_stem;
}
function print_names($array,$key){	

return $array[(int)$key];	

}
/**OTHER FUNCTIONS*/

private function time_elapsed_A($secs){
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
        );
        
    foreach($bit as $k => $v)
        if($v > 0)$ret[] = $v . $k;
        
    return join(' ', $ret);
    }
private function timeliness($Daymaster_phase,$Season){
	/*Compare day master HS with Season HS ( phase ) if it's the same  the phases are timely*/
		$timeliness=false;
		if(strpos($Daymaster_phase, $Season ) != false ) 
					{
			$timeliness="timely";			
		
					}
		else{
			$timeliness="untimely";

		}
			
		return $timeliness;
		}
private function set_cn_profile($time,$date,$timezone){

				$cn_result = (object) [];		
				//Check if birthtime is unknown:
				if($time=='NULL')$time='12:00';


				$d = new \DateTime($date." ".$time, new \DateTimeZone($timezone));
				$date_str= $date;
				list($day,$month,$year) = sscanf("$date_str", "%d-%d-%d");
				$us_date="$month/$day/$year";				
				$month_c=$month;		
				$day_c= $day;		
				$year_c=$year;	
				// echo ("date values ");
				// var_dump($month_c,$day_c,$year_c);
		
				//$time_c=parse_time_string($time);	


				if($time!='NULL'&& $this->BirthtimeUnknown==FALSE){



					$time_c=$time; //no need to parse time string . we need to check validate it at time birth input

					$EB_time_c=(String)$this->find_hour_branch_nbr($time_c);


						try{ $hresult=$this->search_values($this->HSIA,$year_c,$month_c,$day_c);} 
						
						catch( \Throwable $th )	{

							return 0;


						}


						$day_stem=$hresult->HS_Day;

						$HS_time_c=(String)$this->find_hour_stem_nbr($time_c,$this->find_early_hour_rat_stem_nbr($day_stem));	

						$cn_result->HS_Hour = ten_heavenly_stems_english_names[$HS_time_c];
						$cn_result->EB_Hour = twelve_earthly_branches_phase_names[$EB_time_c];
						$cn_result->EB_Hour_eng = twelve_earthly_branches_eng_names[$EB_time_c];

						$cn_result->HS_Hour_nbr = $HS_time_c;
						$cn_result->EB_Hour_nbr = $EB_time_c;



				}


				else {

					$hresult=$this->search_values($this->HSIA,$year_c,$month_c,$day_c);	

					$day_stem=$hresult->HS_Day;

					$cn_result->HS_Hour = "N/A";
					$cn_result->EB_Hour = "N/A";
					$cn_result->EB_Hour_eng = "N/A";
					$cn_result->HS_Hour_nbr = "N/A";
					$cn_result->EB_Hour_nbr = "N/A";


				}
			

				$timeliness=$this->timeliness($day_stem,$hresult->Season);
				
			  $cn_result->bd=$date;
			  $cn_result->bt=$time; 	  

				
				$cn_result->HS_Day = ten_heavenly_stems_english_names[$hresult->HS_Day];
				
				$cn_result->HS_Month = ten_heavenly_stems_english_names[$hresult->HS_Month];

				$cn_result->HS_Year = ten_heavenly_stems_english_names[$hresult->HS_Year];
				
				
	
			  
			
				$cn_result->EB_Day = twelve_earthly_branches_phase_names[$hresult->EB_Day];

				
				$cn_result->EB_Month =twelve_earthly_branches_phase_names[$hresult->EB_Month];
				$cn_result->EB_Year =twelve_earthly_branches_phase_names[$hresult->EB_Year];

			  
				$cn_result->EB_Day_eng = twelve_earthly_branches_eng_names[$hresult->EB_Day];
				$cn_result->EB_Month_eng = twelve_earthly_branches_eng_names[$hresult->EB_Month];
				$cn_result->EB_Year_eng = twelve_earthly_branches_eng_names[$hresult->EB_Year];

				/* yy is for determining the yin and yang eontent*/ 
				
		
				$cn_result->HS_Day_nbr = $hresult->HS_Day;
				$cn_result->HS_Month_nbr = $hresult->HS_Month;
				$cn_result->HS_Year_nbr = $hresult->HS_Year;
				
				
				$cn_result->EB_Day_nbr =$hresult->EB_Day;
				$cn_result->EB_Month_nbr =$hresult->EB_Month;
				$cn_result->EB_Year_nbr =$hresult->EB_Year;			  	

				$cn_result->Season = twelve_season_english[$hresult->Season];
			  $cn_result->Timeliness=$timeliness;
				$cn_result->elm_level=$this->set_element_level($cn_result);
				$cn_result->element_prof=$this->set_element_label($cn_result->elm_level);	
				$cn_result->elm_level_str=implode(",",(array)$cn_result->elm_level);
				$this->set_yinyang($cn_result);
				
			
		
			return $cn_result;
		
		}




private function set_yinyang($cn_result){


	$yang_HS=0;$yin_HS=0;$yang_EB=0;$yin_EB=0;
 if( 
	$cn_result->HS_Hour!= "N/A" && $cn_result->EB_Hour!=	"N/A" && $cn_result->EB_Hour_eng!=	"N/A" && $cn_result->	HS_Hour_nbr
	!=	"N/A" &&  $cn_result->EB_Hour_nbr!=	"N/A" ){


	$this->yy($cn_result->HS_Hour_nbr,$yin_HS,$yang_HS,"hs");
	$this->yy($cn_result->EB_Hour_nbr,$yin_EB,$yang_EB,"eb");
	}


	$this->yy($cn_result->HS_Day_nbr,$yin_HS,$yang_HS,"hs");
	$this->yy($cn_result->HS_Month_nbr,$yin_HS,$yang_HS,"hs");
	$this->yy($cn_result->HS_Year_nbr,$yin_HS,$yang_HS,"hs");	

	$this->yy($cn_result->EB_Day_nbr,$yin_EB,$yang_EB,"eb");
	$this->yy($cn_result->EB_Month_nbr,$yin_EB,$yang_EB,"eb");
	$this->yy($cn_result->EB_Year_nbr ,$yin_EB,$yang_EB,"eb");



	$total_yang=$yang_HS+$yang_EB;
	$total_yin=$yin_HS+$yin_EB;

	$total_yang_percent=$total_yang/($total_yang+$total_yin);
	$total_yin_percent=$total_yin/($total_yang+$total_yin);

	$this->yang_level=$total_yang_percent*100;
	$this->yin_level=$total_yin_percent*100;
	//add to cn_result for better profile manipulation
	$cn_result->yang_level=$this->yang_level;
	$cn_result->yin_level=$this->yin_level;




	return 0;
}			
private function yy($pillar,&$yin,&$yang,$HE_flag){



	if($HE_flag=="hs")
	switch($pillar){

		case 1: $yang++;break;
		case 2: $yin++;break;
		case 3: $yang++;break;
		case 4: $yin++;break;
		case 5: $yang++;break;
		case 6: $yin++;break;
		case 7: $yang++;break;
		case 8: $yin++;break;
		case 9: $yang++;break;
		case 10: $yin++;break;
		}
	else
	switch($pillar){

		case 1: $yang++;break;
		case 2: $yin++;break; 
		case 3: $yang++;break;
		case 4: $yin++;break;
		case 5: $yang++;break;
		case 6: $yin++;break;
		case 7: $yang++;break;
		case 8: $yin++;break;
		case 9: $yang++;break;
		case 10: $yin++;break;
		case 11: $yang++;break;
		case 12: $yin++;break;
		}			
		
			return 0;
	

}		
public function get_cn_profile(){

		return $this->cn_result;

	}
public function get_cn_profile_csv($id){
		$filename='cn_export_'.$id.'.csv';
		$fp = fopen($filename, 'w');
		$list=(array)$this->cn_result;
		$header_array=[];
		$row_array=[];
		$i=0;
		foreach ($list as $field) {
		
			array_push($header_array,array_keys($list)[$i]);
			array_push($row_array,$field);
			$i++;
		
		}
		$data_array=array($header_array,$row_array);

		foreach ($data_array as $fields) {
			fputcsv($fp, $fields);		
		}
		
		fclose($fp);
		
	}

private function set_cn_result_display($cn_result)
	{ 
			$cn_result_display= "<div class=\"table-responsive  fs-6 fs-sm-6 \"><table class=\"table table-bordered\">"	
			."<tr class=\" fs-6 fs-sm-6 \">".
				 "<th>"."Type"."</th>". "<th>".	"Hour". "</th>"."<th>".	"Day". "</th>"."<th>"."Month"."</th>"."<th>"."Year"."</th>"."<th>"."Season"."</th>".
				
				 "</tr>"
				 
				 ."<tr>".
				 
				 "<td>"."Heavely Stem"."</td>"
				 
				 ."<td>". $cn_result->HS_Hour."</td>".
				 "<td>". $cn_result->HS_Day. "</td>".
					"<td>".  $cn_result->HS_Month."</td>"
					."<td>".$cn_result->HS_Year."</td>"
					."<td>".$cn_result->Season."</td>"
					."</tr>"
					."<tr>".
				 
					"<td>"."Heavely Stem"."</td>"
					
					."<td>". $this->get_pilar_image($cn_result->HS_Hour ,"HS")."</td>"
					
					."<td>". $this->get_pilar_image($cn_result->HS_Day ,"HS")."</td>"
					."<td>". $this->get_pilar_image($cn_result->HS_Month ,"HS")."</td>"
					."<td>". $this->get_pilar_image($cn_result->HS_Year ,"HS")."</td>"
					."<td>".$cn_result->Timeliness."</td>"
					   
				."</tr>"
				
				 ."<tr>"
				 
				 ."<td>"."Earthly Branch"."</td>".
				 
				 "<td>".$cn_result->EB_Hour."</td>"
				 ."<td>".$cn_result->EB_Day."</td>".
				 "<td>".$cn_result->EB_Month. "</td>"
				 ."<td>".$cn_result->EB_Year. "</td>"
				 
				 ."</tr>".
				 "<tr>".
				 
				 "<td>"."Earthly Branch  Image"."</td>"
				 
				 ."<td>".$this->get_pilar_image($cn_result->EB_Hour_eng ,"EB",twelve_earthly_branches_phase_names,twelve_earthly_branches_eng_names)."</td>".
				 "<td>". $this->get_pilar_image($cn_result->EB_Day_eng ,"EB",twelve_earthly_branches_phase_names,twelve_earthly_branches_eng_names)."</td>".
				 "<td>". $this->get_pilar_image($cn_result->EB_Month_eng ,"EB",twelve_earthly_branches_phase_names,twelve_earthly_branches_eng_names)."</td>".
				 "<td>". $this->get_pilar_image($cn_result->EB_Year_eng ,"EB",twelve_earthly_branches_phase_names,twelve_earthly_branches_eng_names)."</td>"
			
				."</tr>".
				 "<tr>".
				"<td>"."Element %"."</td>"
				 
				."<td>"."EARTH:".$cn_result->elm_level[0]. "</td>".
				"<td>"."METAL:".$cn_result->elm_level[1]. "</td>".
				"<td>"."WATER:".$cn_result->elm_level[2]. "</td>".
				"<td>"."WOOD:".$cn_result->elm_level[3]. "</td>".
				"<td>"."FIRE:".$cn_result->elm_level[4]. "</td>".				   
			   "</tr>".		
			   "<tr>"."<td>Element Profile</td>"."<td>". $this->display_el_label($cn_result->element_prof). "</td>". "</tr>".		
			   "<tr>"."<td>YY level</td>"."<td>". $this->display_yy_level(). "</td>". "</tr>".					
				"</table></div>"	;
		return $cn_result_display;
	}


public function get_cn_result_display(){
		
	
	
	return( $this->cn_result_display);
}


private function set_Cn_Row(){


	$this->cn_row_data=[

		'HS_Hour'=> $this->cn_result->HS_Hour,
		'EB_Hour'=> $this->cn_result->EB_Hour,
		'HS_Day'=> $this->cn_result->HS_Day,
		'EB_Day'=> $this->cn_result->EB_Day,
		'HS_Month'=> $this->cn_result->HS_Month,
		'EB_Month'=> $this->cn_result->EB_Month,
		'HS_Year'=> $this->cn_result->HS_Year,
		'EB_Year'=> $this->cn_result->EB_Year,
		'EB_Hour_eng'=> $this->cn_result->EB_Hour_eng,
		'EB_Day_eng'=> $this->cn_result->EB_Day_eng,
		'EB_Month_eng'=> $this->cn_result->EB_Month_eng,
		'EB_Year_eng'=> $this->cn_result->EB_Year_eng,
		'Season'=> $this->cn_result->Season,
		'Element'=>  $this->display_el_label($this->cn_result->element_prof)
		];

}


public function getCn_Row(){




	return $this->cn_row_data;
}
public function display_el_label($elementprof) {
switch ($elementprof)

{	
	case 0:
		return "earth";
	case 1:
		return "metal";
	case 2:
		return "water";
	case 3:
		return "wood";		
	case 4:
		return "fire";
	case 5:
			return "neutral";
}

}


public function display_yy_level() {
	
	return " Yin:  ". $this->yin_level." Yang:  ".$this->yang_level;
	
}


private function set_element_level($cn_result){
	$fir=0;	
	$ear=0;	
	$met=0;	
	$wat=0;	
	$woo=0;

	$rat=0;$ox=0;$tiger=0;$rabbit=0;$dragon=0;$snake=0;$horse=0;$sheep=0;$monkey=0;$rooster=0;$dog=0;$pig=0;
	

	$strval="";

	foreach ($cn_result as $key =>$value){
		
		$strval.= " ".$value;
	}

	//echo($strval);
	
	//obtain heavenly stem element
	$fir=substr_count($strval,"fire");
	$ear=substr_count($strval,"earth");
	$met=substr_count($strval,"metal");
	$wat=substr_count($strval,"water");	
	$woo=substr_count($strval,"wood");

	$yang=substr_count($strval,"yang");
	$yin=substr_count($strval,"yang");

	$rat=substr_count($strval,"rat");
	$ox=substr_count($strval,"ox");
	$tiger=substr_count($strval,"tiger");
	$rabbit=substr_count($strval,"rabbit");
	$dragon=substr_count($strval,"dragon");
	$snake=substr_count($strval,"snake");
	$horse=substr_count($strval,"horse");
	$sheep=substr_count($strval,"sheep");
	$monkey=substr_count($strval,"monkey");
	$rooster=substr_count($strval,"rooster");
	$dog=substr_count($strval,"dog");
	$pig=substr_count($strval,"pig");
	//[$earth,$metal,$water,$wood,$fire]



	$hhs=hidden_stems;
	$five_el_array=[0,0,0,0,0];

	

	$hhs_r[0]=$this->get_hidden_stems($hhs,"rat",$rat,$five_el_array);
	$hhs_r[1]=$this->get_hidden_stems($hhs,"ox",$ox,$five_el_array);
	$hhs_r[2]=$this->get_hidden_stems($hhs,"tiger",$tiger,$five_el_array);
	$hhs_r[3]=$this->get_hidden_stems($hhs,"rabbit",$rabbit,$five_el_array);
	$hhs_r[4]=$this->get_hidden_stems($hhs,"dragon",$dragon,$five_el_array);
	$hhs_r[5]=$this->get_hidden_stems($hhs,"snake",$snake,$five_el_array);
	$hhs_r[6]=$this->get_hidden_stems($hhs,"horse",$horse,$five_el_array);
	$hhs_r[7]=$this->get_hidden_stems($hhs,"sheep",$sheep,$five_el_array);
	$hhs_r[8]=$this->get_hidden_stems($hhs,"monkey",$monkey,$five_el_array);
	$hhs_r[9]=$this->get_hidden_stems($hhs,"rooster",$rooster,$five_el_array);
	$hhs_r[10]=$this->get_hidden_stems($hhs,"dog",$dog,$five_el_array);
	$hhs_r[11]=$this->get_hidden_stems($hhs,"pig",$pig,$five_el_array);


	$hhs_t=array_sum($hhs_r);
	

	

	//obtain earthly branch element
	
	$water=$rat+$pig;
	$wood=$tiger+$rabbit;
	$metal=$rooster+$monkey;
	$earth=$ox+$sheep+$dragon+$dog;
	$fire=$horse+$snake;


	//obtain hidden stem element from branches	


	$earth_hhs=$five_el_array[0];
	$metal_hhs=$five_el_array[1];	
	$water_hhs=$five_el_array[2];
	$wood_hhs=$five_el_array[3];	
	$fire_hhs=$five_el_array[4];
	
	$t_earth=$earth+$ear+$earth_hhs;
	$t_metal=$metal+$met+$metal_hhs;
	$t_wood=$wood+$woo+$water_hhs;
	$t_water=$water+$wat+$wood_hhs;
	$t_fire=$fire+$fir+$fire_hhs;	

	$total_five_elem=$t_fire+$t_earth+$t_metal+$t_wood+$t_water;

	$fire_p=round($t_fire/$total_five_elem*100,0);
	$earth_p=round($t_earth/$total_five_elem*100,0);
	$metal_p=round($t_metal/$total_five_elem*100,0);
	$wood_p=round($t_wood/$total_five_elem*100,0);
	$water_p=round($t_water/$total_five_elem*100,0);

	

	return [$earth_p,$metal_p,$water_p,$wood_p,$fire_p];
	
}

// Define a function to find the most abundant element and apply your labeling criteria
function set_element_label($elementProportions) {
// 0: earth,1:metal  2:wood, 3: water, 4:fire
    // Find the element with the highest proportion
    $mostAbundantElement = array_search(max($elementProportions), $elementProportions);
    
    // Check if there are multiple elements with similar proportions
    $maxProportion = $elementProportions[$mostAbundantElement];
    $similarElements = [];
    
    foreach ($elementProportions as $element => $proportion) {
        if ($element !== $mostAbundantElement && abs($proportion - $maxProportion) < 0.05) {
            $similarElements[] = $element;
        }
    }
    
    // Label the profile based on your criteria
    if (count($similarElements) === 0) {
        return $mostAbundantElement;
    } else {
        return 5; // Element profile is neutral, whiuch means there is at least 2 elements that share same proportion, 
    }
}


private function get_hidden_stems($hidden_stems,$eb_name,$eb_count,&$five_el_array){
	
	//eb_caoint is the number of times that an eb appeared in the chart

	$earth=0;
	$metal=0;
	$water=0;
	$wood=0;
	$fire=0;	

	//iterate through hidden_stems definitions

	foreach($hidden_stems as $eb=>$stem){
		
		
				// COMPROBAR EB EN HIDDEN STEMS ES IGUAL AL EB QUE SE ESTA ANALIZANDO
				//Iterate throug all hidden stems
			foreach($stem as $key=>$value){
				//Corregir para cada animal. mas preciso
				
				$stem_holder=explode(" ",$value);

				switch($stem_holder[0]){
					case "yin":$this->yin_level+1;
					case "yang":$this->yang_level+1;
				}
				switch($stem_holder[1]){
					case "earth":$earth+=1;$five_el_array[0]+=1;$five_el_array[0]*=$eb_count;break;
					case "metal":$metal+=1;$five_el_array[1]+=1;$five_el_array[1]*=$eb_count;break;
					case "water":$water+=1;$five_el_array[2]+=1;$five_el_array[2]*=$eb_count;break;
					case "wood":$wood+=1;$five_el_array[3]+=1;$five_el_array[3]*=$eb_count;break;
					case "fire":$fire+=1;$five_el_array[4]+=1;$five_el_array[4]*=$eb_count;break;
				}
				

				
		}
	

		
	return 0;


	
	}

}


}


