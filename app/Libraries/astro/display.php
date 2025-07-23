<?php
//include("header.php");
include_once 'constants.php';
include('data_export/csv-extract.php');
// include ('cn/cn.php');
// include ('num/num.php');
// include ('may/my.php');
// include ('zod/zod.php');
include ('db/db.php');
include ('cos/cosmo.php');
include('profile.php');
include ("match/people.php");
include ('match/pMatch.php');


header('Content-Type: text/html; charset=utf-8');
//Display all manual

?>


<?php

if (session_status() == PHP_SESSION_NONE) {
                                  session_start();
                              }
if (isset( $_POST['displ_type'])){
	
		if ($_POST['displ_type']!='null'  ){    
			 $displ_type=$_POST['displ_type'];
			  }
}

if (isset( $_POST['full_name'])){
	
		if ($_POST['full_name']!='null'  ){    
			 $full_name=$_POST['full_name'];
			}
}

if (isset( $_POST['person'])){
        
                 if(   $_POST['person']!='null'  ){ 
                               $person=$_POST['person']; 
            }
}

/*For displaying profiles from csv files**/
/*
if ($_SESSION['path']!='null'){    
  $path=$_SESSION['path'];
    }
*/
if (isset( $_POST['path'])){
        
                 if( $_POST['path']!='null'  ){ 
                               $path=$_POST['path']; 
            }
}
/***************END PF TESTING PARAMETER AREA********************/

$p1=new stdClass();
$p2=new stdClass();

$database=new db(HOST,USER,PASSWORD,DATABASE);
echo"<center>";
	
/*PROFILE DISPLAY*/
  
	//Create 2 person  objects to store data

		//TEST
	/* 	$_POST['name1']="ramon";
		$_POST['name2']="irene";
		$_POST['bd1']="30-01-1953";
		$_POST['bt1']="14:30";

		$_POST['bd2']="10-05-1965";
		$_POST['bt2']="23:00"; */

		//Check if the entry data is correctly sent by post headers
		$checkPost=isset ($_POST['bd1']) && isset($_POST['bt1']) && isset ($_POST['bd2']) && isset($_POST['bt2']) &&	 
		isset($_POST['name1']) && isset($_POST['name2']);
		if ($checkPost)
		{
			echo("<h2>POST SET</h2>");

		//	echo( $_POST['name1'] ." ".$_POST['bd1'] ." ". $_POST['bt1'] ." ".  $_POST['name2'] ." ". $_POST['bd2']	 ." ". $_POST['bt2']  );
			echo("</br>");
			

				$p1->bd=$_POST['bd1']; 
				$p1->tb=$_POST['bt1'];
				$p1->name=$_POST['name1'];					
				$p2->bd=$_POST['bd2'];
				$p2->tb=$_POST['bt2'];
				$p2->name=$_POST['name2'];	

			/* 	$row['day']=
				$row['month']=
				$row['year']=
				$row['hour']=
				$row['minute']=		
				$row['name']=
				$row['surname']=
				$row['ID']=
 */
			
		}
		//IF NOT SET ON POST, USE THE FOLLOWING VALUES FOR TEST
		
		else 
			{
			echo"<h1>DB RETRIEVED</h1>";
			//For testing purposes as info did not come from start.php or external sources API 
			// dont use PM or AM anymore or trim from astro scripts
				$p1->id=3;		
				$row1=$database->db_connect($p1->id,"birth_info");		
				$prof_1=new Profile($row1);
				$prof_1->display_profile();
				$p2->id=2;		
				$row2=$database->db_connect($p2->id,"birth_info");
				$prof_2=new Profile($row2);
				$prof_2->display_profile();
				
				
			
				print_r("<br>");
		
			}
				
			


	/*CN MATCH */
			
			$match_type="cn";
			$matchCN=new pMatch($prof_1,$prof_2,$match_type,HOST,DATABASE,USER,PASSWORD);			
			$cn_day_master_score=$matchCN->do_cn_match("day"); /*ONLY DAY COMBINATIONS ARE TAKEN INTO ACCOUNT*/
			$cn_score=$cn_day_master_score;

			
			//Reset the compared of previous match
			 //Display the chinese table
			//echo $matchCN->get_results_table($cn_results);
			echo "<br>";
			echo("CN score is: ".$cn_score);

			$match_type="co";						
			
	//---ZODIAC NATCH
		//	$zd_results=my_manual_2_p($p1->bd,$timeParsed1,$p2->bd,$timeParsed2,$tzolkin0);		


			//$zod_results$zd->zod_manual_2_p();
	//---HD MATCH
	
	//----MAY MATCH
			$match_type="my";
			/*Get MY results object First element for 1st p, 2nd element for 2nd p*/	
			//$my_results=displ_match_2_mayan($may1,$may2);

			$matchMY=new pMatch($prof_1,$prof_2,$match_type);
			$may_score=$matchMY->do_my_match();
			echo "<br>";
			echo("   MY score: ".$may_score);
			echo "<br>";

	//---NUM	

	// 		/*Get NUM results object First element for 1st p, 2nd element for 2nd p*/	
	//		$num_results=displ_num_manual_for_match_2_p($p1->name,$p2->name);
	// 		$num_score=0;
	// 		$matchNUM=new Match($num_results,"num");
	// 		$num_score=$matchNUM->do_num_match($p1,$p2);
	// 		echo("mum score: ".$matchNUM->do_num_match($p1,$p2));
			

	// 	//	echo("cn hs 1on1 score day combinations: ".$matchCN->do_cn_match("hs_day"));
	

	//  DISPLAY ALL 	 COMBINED SCORE RESULT 
		$_combined_score=$cn_score; // NOTE: I need to add other scores when matching definition is completed	
		$_combined_score+=$may_score/*+$num_score*/;

		echo("<div id=\"result_c\">");
		echo("<br>hs score: ".$_combined_score);	
		echo("<br>Combined score: ".$_combined_score);
		echo ("</div>");

	



	/*EXPORTS*/
	$prof_1->cn_prof->get_cn_profile_csv("p1");
	$prof_2->cn_prof->get_cn_profile_csv("p2");
	include("footer.php");




/*FUNCTIONS************************************************************************************/


/*************************GENERAL FUNCTIONS *****************************************************/

function open_file($path)
	{
	$Content=file_get_contents($path);
	
	return $Content;	
	}

function create_tooltip($name)
	{

	$path="numerology/numbers/$name.txt";
	$text=open_file($path);
	return "<h4 title=\"$text\"><a href=\"numerology/numbers/$name.txt\">$name</a></h3>";
	}
		


function parse_time_string($time_String)
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

				if ($time_hour<12){	
					$time_hour+=12;
				}
				else{
					throw new Exception('Error: PM hour higher than 12');

				}
			$time_c=(string)$time_hour.":".$time_mins;
		
		

		}
	$time_c=trim($time_c);
	return $time_c;
			

	}



	

	function ajax_call($server_root){

		$js="

		<script type=\"javascript\">
		$(document).ready
		(

		$.ajax({

			url : '$server_root./cos/dual_cosmopower.php',
			type : 'POST',
			data : {
				'numberOfWords' : 10
			},
			dataType:'html',
			success : function(data) {              
				$('#cos_result').html(data);
			},
			error : function(request,error)
			{
				console.log("."Request".': "+JSON.stringify(request));
			}
		});
		}
			</script>';

			return $js;

	}

/*******************************DISPLAY FUNCTIONS****************************************************/		

function displ_2_mayan($my1,$my2)
	{
		$my1=$my1->get_my_result_display();
		$my2=$my2->get_my_result_display();
		$combined='<div">'.$my1.$my2.'</div>';
		echo $combined;
	}

function displ_2_zod($zd1,$zd2)
	{
		$zd1=$zd1->get_zd_result_display();
		$zd2=$zd2->get_zd_result_display();
		$combined='<div">'.$zd1.$zd2.'</div>';
		echo $combined;
	}





/*MATCH DISPLAY*****************************************************/


/* CN Manual by user Match Display */
// function wmanual($date1,$time1,$date2,$time2,$twelve_earthly_branches_phase_names,$twelve_earthly_branches_english_names,$twelve_earthly_branches_chinese_names
// 	,$heavenly_stems_english_names,$heavenly_stems_chinese_names,$twelve_season_phases,
// 	$twelve_season_english,$HSIA)
// 	{
				
// 		$date_str= $date1;
// 		//echo $date_str;
// 		list($day,$month,$year) = sscanf("$date_str", "%d-%d-%d");
// 		$us_date="$month/$day/$year";
// 		$month_c=$month;
// 		$day_c= $day;
// 		$year_c=$year;	
// 		$time_c=$time1;
		
// 		$time_c=parse_time_string($time_c);	
// 		$EB_time_c=(String)find_hour_branch_nbr($time_c);
// 		$hresult1=search_values3($HSIA,$year_c, $month_c,$day_c);		
// 		$day_stem=$hresult1->HS_Day;
// 		$HS_time_c=(String)find_hour_stem_nbr($time_c,find_early_hour_rat_stem_nbr($day_stem));	
// 		$timeliness=timeliness($hresult1->Season,$hresult1->HS_Day);
		
// 		$HtmlTable_result=displ_chinese($hresult1,$twelve_earthly_branches_phase_names,$twelve_earthly_branches_english_names, 
// 		$twelve_earthly_branches_chinese_names, $heavenly_stems_english_names,  $heavenly_stems_chinese_names,
// 		$twelve_season_phases,$twelve_season_english,$EB_time_c,$HS_time_c,$timeliness);
// 		echo $HtmlTable_result->Table_result;

// 		/***PERSON 2******************************************/
// 		$date_str= $date2;
// 		//echo $date_str;

// 		list($day,$month,$year) = sscanf("$date_str", "%d-%d-%d");
// 		$us_date="$month/$day/$year";
// 		$month_c=$month;
// 		$day_c= $day;
// 		$year_c=$year;	
// 		$time_c=$time2;
		
// 		$time_c=parse_time_string($time_c);	
// 		$EB_time_c=(String)find_hour_branch_nbr($time_c);
// 		$hresult2=search_values3($HSIA,$year_c, $month_c,$day_c);		
// 		$day_stem=$hresult2->HS_Day;
// 		$HS_time_c=(String)find_hour_stem_nbr($time_c,find_early_hour_rat_stem_nbr($day_stem));	
// 		$timeliness=timeliness($hresult2->Season,$hresult2->HS_Day);
		
// 		$HtmlTable_result=displ_chinese($hresult2,$twelve_earthly_branches_phase_names,$twelve_earthly_branches_english_names, $twelve_earthly_branches_chinese_names, 
// 		$heavenly_stems_english_names,  $heavenly_stems_chinese_names,$twelve_season_phases,
// 		$twelve_season_english,$EB_time_c,$HS_time_c,$timeliness);
		
// 		return $HtmlTable_result->Table_result;
		
// 		}
		

/*NUM Display Match*/
function displ_2_num($name1,$name2){
	
	}



/*COS Displa Match*/
function cos_manual_2_p($cp,$db,$id,$username)
	{
				$conn=$db->makeconnection();
				// get ID1 and ID2
				$id[1] = $db->safeEscapeString($conn, $id[0]);
				$id[2] = $db->safeEscapeString($conn, $id[1]);


				for ($xx = 1; $xx <= 2; $xx++)
				{
				$sql = "SELECT * FROM birth_info WHERE ID='$id[$xx]' And entered_by='$username'";
		
				$result =  $db->make_query($conn, $sql);    
				$row = mysqli_fetch_array($result);
				$num_rows = MYSQLI_NUM_rows($result);
					$sw_path="/sweph";
					$sw_path="";
					if ($xx == 1)
					{
					 // $header1 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					 // $line1 = $existing_name1 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
			  
					 $cp->CalculatePositions($id[1],$sw_path,$sw_path);
			  
					  
					  echo "BEGIN OF GENERATE RESULT";
			  
					  // assign data from database into arrays for display
					  $pl_name1[0] = "Sun";
					  $pl_name1[1] = "Moon";
					  $pl_name1[2] = "Mercury";
					  $pl_name1[3] = "Venus";
					  $pl_name1[4] = "Mars";
					  $pl_name1[5] = "Jupiter";
					  $pl_name1[6] = "Saturn";
					  $pl_name1[7] = "Uranus";
					  $pl_name1[8] = "Neptune";
					  $pl_name1[9] = "Pluto";
					  $pl_name1[10] = "Ascendant";
					  $pl_name1[11] = "House 2";
					  $pl_name1[12] = "House 3";
					  $pl_name1[13] = "House 4";
					  $pl_name1[14] = "House 5";
					  $pl_name1[15] = "House 6";
					  $pl_name1[16] = "House 7";
					  $pl_name1[17] = "House 8";
					  $pl_name1[18] = "House 9";
					  $pl_name1[19] = "MC (Midheaven)";
					  $pl_name1[20] = "House 11";
					  $pl_name1[21] = "House 12";
			  
					  for ($z = 0; $z <= 21; $z++)
					  {
						$longitude1[$z] = $cp->longitude[$z];
						$declination1[$z] = $cp->declination[$z];
					  }
			  
					  for ($z = 0; $z <= 9; $z++)
					  {
						$house_pos1[$z] = $cp->house_pos[$z];
					  }
			  
					  $hob[1] = $row['hour'];
					  $mob[1] = $row['minute'];
					}
					//for person 2
					if ($xx == 2)
					{
					//  $header2 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					//  $line2 = $existing_name2 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
			  
					  // assign data from database into arrays for display 
					  for ($z = 0; $z <= 21; $z++)
					  {
						$pl_name2[$z] = $pl_name1[$z];
					  }
			  
					  $cp->CalculatePositions($id[2],$sw_path,$sw_path);
			  
					  for ($z = 0; $z <= 21; $z++)
					  {
						$longitude2[$z] = $cp->longitude[$z];
						$declination2[$z] = $cp->declination[$z];
					  }
			  
					  for ($z = 0; $z <= 9; $z++)
					  {
						$house_pos2[$z] = $cp->house_pos[$z];
					  }
			  
					  $hob[2] = $row['hour'];
					  $mob[2] = $row['minute'];
					}
	
				}
				$result=new stdclass();
				$result->longitude1=$longitude1;
				$result->longitude2=$longitude2;
				$result->declination1=$declination1;
				$result->declination2=$declination2;
				$result->hob=$hob;
				$result->mob=$mob;
				$result->house_pos1=$house_pos1;
				$result->house_pos2=$house_pos2;
				$result->cp=$cp;
				return $result;

			};

/*ZOD Match display*/
// function zod_manual_2_p($date1,$time1,$date2,$time2,$bp1,$bp2){

// 	$zod_1=new zod();
// 	$zod_2=new zod();
// 	$zod_result=new stdclass();


// 	return $zod_result;
// };


/*READING DISPLAY******************************************************/

/*CN Display */

/***CN Display 2 charts */
function displ_2_chinese($cn1,$cn2)
{	
	
	$cn_result = new stdClass();/*object to return*/			
	$result_1=$cn1->get_cn_result_display();	
	$result_2=$cn2->get_cn_result_display();
	/**********************DISPLAY BOTH CN ***************************************/
	/*Object to dispay bazi of both persons */
	$cn_result_display= "<table class=\"table\">".$result_1.$result_2."</table>";			 
	
	echo $cn_result_display; /*Contains the string for table*/	
	;
}





/*DATA ANAYLISIS FUNCTIONS**********************************************/


function export_csv(){





}


