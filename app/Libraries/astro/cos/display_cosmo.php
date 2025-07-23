<?php
header('Content-Type: text/html; charset=utf-8');
//Display all manual
error_reporting(E_ALL | E_STRICT);
?>

<head>
<meta charset="ISO-8859-1">
<link rel="stylesheet" href="style.css">
<script>	
function goBack() { window.history.back();}
</script>
</head>

<?php


include ( 'cosmo.php');
include ( '../db/db.php');



	
	
			//---COSMO

						
			$_SESSION['username']="ramonp";
			$_SESSION['is_logged_in']=True;

			if ($_SESSION['is_logged_in'] == False) { exit(); }

			$no_interps = False;     //set this to False when you want interpretations

			echo "<center>";
			//TESTING
			
			 $_POST["id1"]=4;
			 $_POST["id2"]=3;
			// $id=[];
			$id[0]=$_POST["id1"];
			$id[1]=$_POST["id2"];
			
			// connect to and point to the proper database
			
			$cosmodynes_r=new stdClass();	
			$username = $_SESSION['username'];
			$match_type="cosmo";

			$db=new db("localhost","root","","q");

			$match_type="cosmo";

			$cs=new cosmo($db);

			$cs_results=cos_manual_2_p($cs,$db,$id,$username);

			$displayed_c=display_cos($cs_results);

			echo($displayed_c);




	function cos_manual_2_p($cp,$db,$id_in,$username)
	{
				$conn=$db->makeconnection();
				// get ID1 and ID2
				$id[0] = $db->mysqli_real_escape_string_mimic($id_in[0]);
				$id[1] = $db->mysqli_real_escape_string_mimic($id_in[1]);


				for ($xx = 0; $xx <= 1; $xx++)
				{
				$sql = "SELECT * FROM birth_info WHERE ID='$id[$xx]' And entered_by='$username'";
		
				$result = $db->make_query($conn, $sql);    
				$row = mysqli_fetch_array($result);
				$num_rows = MYSQLI_NUM_rows($result);
	
				$secs=0;
					if ($xx == 0)
					{
					 
					  $existing_name1 = $row['name'];
					  $date = DateTimeImmutable::createFromFormat('U',  mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					  echo $date->format('Y-m-d');		

					//  $header1 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					 // $line1 = $existing_name1 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
			  
					  $cp->CalculatePositions($id[0]);
			  
					  
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
			  
					  $hob[0] = $row['hour'];
					  $mob[0] = $row['minute'];
					}

					//For person 2
					if ($xx == 1)
					{
					 $existing_name2 = $row['name'];

					 $date = DateTimeImmutable::createFromFormat('U',  mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					 echo $date->format('Y-m-d');		


					// $header2 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
					// $line2 = $existing_name2 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
						
					  // assign data from database into arrays for display 
					  for ($z = 0; $z <= 21; $z++)
					  {
						$pl_name2[$z] = $pl_name1[$z];
					  }
			  
					  $cp->CalculatePositions($id[1]);
			  
					  for ($z = 0; $z <= 21; $z++)
					  {
						$longitude2[$z] = $cp->longitude[$z];
						$declination2[$z] = $cp->declination[$z];
					  }
			  
					  for ($z = 0; $z <= 9; $z++)
					  {
						$house_pos2[$z] = $cp->house_pos[$z];
					  }
			  
					  $hob[1] = $row['hour'];
					  $mob[1] = $row['minute'];
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
				$result->name1=$existing_name1;
				$result->name2=$existing_name2;
				$result->cp=$cp;
				$result->pname1=  $pl_name1;
				$result->pname2=  $pl_name2;
				return $result;

			};

//Gets $result object returned by cos_manual_2_p and displays the content in a readable manner
	function display_cos($combined)
	{
		$export_="";
		$longitude1=$combined->longitude1; 
		$declination1=$combined->declination1;	 
		$house_pos1=$combined->house_pos1; 
		$longitude2=$combined->longitude2; 
		$declination2=$combined->declination2; 
		$house_pos2=$combined->house_pos2;
		$hob=$combined->hob; 
		$mob=$combined->mob;
		$existing_name1=$combined->name1;
		$existing_name2=$combined->name2;
		$pl_name1=$combined->pname1;
		$pl_name2=$combined->pname2;
		
		//Tis is the basic data to calculate the score
		$num_MRs = $combined->cp->GetMutualReceptions($longitude1, $longitude2);
		$dynes = $combined->cp->GetCosmodynes($longitude1, $declination1, $house_pos1, $longitude2, $declination2, $house_pos2, $hob, $mob);
		$total_harmony = $dynes[1] + ($num_MRs * 5); //Score result from the calculations
		
		$hr_ob = $hob[0];
		$min_ob = $mob[0];
	
		$ubt1 = 0;
		if (($hr_ob == 12) And ($min_ob == 0))
		{
		$ubt1 = 1;        // this person has an unknown birth time
		}
		$hr_ob = $hob[1];
		$min_ob = $mob[1];
	
		$ubt2 = 0;
		if (($hr_ob == 12) And ($min_ob == 0))
		{
		$ubt2 = 1;        // this person has an unknown birth time
		}
	

	///////////////////////////////START DISPLAYING CONTENT OF cos_manual_2_p result///////////////////////////////////////////////


		//Store all the values in one object for better access:
			$cosmodynes_r=new stdclass();

	
		
		//For person 1
		$cosmodynes_r->name1=$existing_name1;
		//get natal data from cosmo.php
		$cosmodynes_r->natal_d1=$combined->cp->Get_NatalData($pl_name1, $longitude1, $declination1, $house_pos1, $hr_ob, $min_ob);
		
	
		//For person 2
		$cosmodynes_r->name2=$existing_name2;
		//get natal data from cosmo.php
		$cosmodynes_r->natal_d2=$combined->cp->Get_NatalData($pl_name2, $longitude2, $declination2, $house_pos2, $hr_ob, $min_ob);
		
			$cosmodynes_r->score=$total_harmony;
			$export_.=("</BR>");
			$export_.=("score: ");
			$export_.=($cosmodynes_r->score);
			$export_.=("</BR>");
			//print_r($cosmodynes_r->natal_d1);
			
			$export_.=("</br><b>Planets 1</b></br>");
		
		
				$nbr_p=count($cosmodynes_r->natal_d1->planets_r->name) ;
				$counter_p=0;
		
				do{
					$export_.=($cosmodynes_r->natal_d1->planets_r->name[ $counter_p]); $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d1->planets_r->long[ $counter_p]);  $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d1->planets_r->decl[ $counter_p]); $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d1->planets_r->hse[ $counter_p]);
					$export_.=("</br>");
						//print_r($cosmodynes_r->natal_d1->planets_r->name[$counter_p]);
				$counter_p+=1;
			
				} while($counter_p< $nbr_p);

				$export_.=("</br>");
				$export_.=("</br><b>Aspects</b></br>");
				$export_.=("</br>Ascendant</br>");
			
				$export_.=($cosmodynes_r->natal_d1->aspects_r->ascendant);
				$export_.=("</br>");
		
				$export_.=("</br>Houses</br>");		
				
				$nbr_h=count($cosmodynes_r->natal_d1->aspects_r->house) ;
				$counter_h=0; 
		
				$output_array = array();      
				foreach($cosmodynes_r->natal_d1->aspects_r->house as $a) 
				{
						array_push($output_array,$a);
				}
				//print_r($output_array);
				foreach($output_array as $b){
					$export_.=($b);
					$export_.=("</br>");
		
				}
		
				$export_.=("</br>midheaven</br>");
			
				$export_.=($cosmodynes_r->natal_d1->aspects_r->midheaven);
				$export_.=("</br>");  
		
			
				$export_.=("</br><b>Planets 2</b></br>");
		
		
				$nbr_p=count($cosmodynes_r->natal_d2->planets_r->name) ;
				$counter_p=0;
		
				do{
					$export_.=($cosmodynes_r->natal_d2->planets_r->name[ $counter_p]); $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d2->planets_r->long[ $counter_p]);  $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d2->planets_r->decl[ $counter_p]); $export_.=(", ");
					$export_.=($cosmodynes_r->natal_d2->planets_r->hse[ $counter_p]);
					$export_.=("</br>");
						//print_r($cosmodynes_r->natal_d1->planets_r->name[$counter_p]);
				$counter_p+=1;
			
				} while($counter_p< $nbr_p);
				
				$export_.=("</br>");
				$export_.=("</br><b>Aspects</b></br>");
				$export_.=("</br>Ascendant</br>");
			
				$export_.=($cosmodynes_r->natal_d2->aspects_r->ascendant);
				$export_.=("</br>");
		
				$export_.=("</br>Houses</br>");		
				
				$nbr_h=count($cosmodynes_r->natal_d2->aspects_r->house) ;
				$counter_h=0; 
		
				$output_array = array();      
				foreach($cosmodynes_r->natal_d2->aspects_r->house as $a) 
				{
						array_push($output_array,$a);
				}
				//print_r($output_array);
				foreach($output_array as $b){
					$export_.=($b);
					$export_.=("</br>");
		
				}
		
				$export_.=("</br>midheaven</br>");
			
				$export_.=($cosmodynes_r->natal_d2->aspects_r->midheaven);
				$export_.=("</br>");  	  

		return $export_;//Return an html string for display of results
	}



	
	