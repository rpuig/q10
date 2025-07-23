<?php

include ( 'cosmo.php');
include ( 'db.php');
//error_reporting(0);
$db=new db("localhost","root","","q");
$cp=new cosmo($db);
///testing

$_SESSION['username']="ramonp";
$_SESSION['is_logged_in']=True;

if ($_SESSION['is_logged_in'] == False) { exit(); }

  $no_interps = False;     //set this to False when you want interpretations

 // echo "<center>";
    //TESTING
    $_POST["id1"]=3;
    $_POST["id2"]=4;
  // connect to and point to the proper database

  $conn=$db->makeconnection();
  // get ID1 and ID2
  /* $id[1] = $db->safeEscapeString($conn, $_POST["id1"]);
  $id[2] = $db->safeEscapeString($conn, $_POST["id2"]); */
 
  $id[0] = mysqli_real_escape_string($conn, $_POST["id1"]);
  $id[1] = mysqli_real_escape_string($conn, $_POST["id2"]);
  

  $username = $_SESSION['username'];

  $longitude=[];
  $declination=[];
  $house_pos=[];
  $existing_name=[];
  $tz=[];
  $hob=[];
  $mob=[];
  $header=[];
  $line=[];
  //iterate for both the 2 persons to calculate aspects and positions 
  for ($y = 0; $y <= 1; $y++)
  {

    //fetch all data for this record
    $sql = "SELECT * FROM birth_info WHERE ID='$id[$y]' And entered_by='$username'";
    $result =  $db->make_query($conn, $sql);    
    $row = mysqli_fetch_array($result);
    $num_rows = MYSQLI_NUM_rows($result);
    $hob[$y] = $row['hour'];
    $mob[$y] = $row['minute']; 
    $existing_name[$y] = $row['name'];   

    if ($num_rows == 0)
    {
      // echo "<FONT color='#ff0000' SIZE='5' FACE='Arial'><b>I could not find the record(s) you specified. Thank you.</b></font><br><br><br>";
      // mysqli_close($conn);
      // echo "</center>";
     
      exit();
    }
    else
    {
      //assign data from database to local variables
      $secs = "0";
      if ($row['timezone'] < 0)
      {
        $tz[$y] = $row['timezone'];
      }
      else
      {
        $tz[$y] = "+" . $row['timezone'];
      }

     // echo "BEGIN OF GENERATE RESULT <br>";
      
    
        $header[$y] = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT$tz[$y]hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
        $line[$y] = $existing_name[$y] . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz[$y] hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
      
        //Store position values for each person in cp object for tempprary use 
        $pos=$cp->CalculatePositions($id[$y]);        

        // assign data from database into arrays for display
        $pl_name[0] = "Sun";$pl_name[1] = "Moon";$pl_name[2] = "Mercury";$pl_name[3] = "Venus";
        $pl_name[4] = "Mars";$pl_name[5] = "Jupiter";$pl_name[6] = "Saturn";$pl_name[7] = "Uranus";
        $pl_name[8] = "Neptune";$pl_name[9] = "Pluto"; $pl_name[10] = "Ascendant"; $pl_name[11] = "House 2";
        $pl_name[12] = "House 3";$pl_name[13] = "House 4";$pl_name[14] = "House 5";$pl_name[15] = "House 6";
        $pl_name[16] = "House 7";$pl_name[17] = "House 8";$pl_name[18] = "House 9";$pl_name[19] = "MC (Midheaven)";
        $pl_name[20] = "House 11"; $pl_name[21] = "House 12";

          //store the cp object values for longitude and declination into array for easier access

        for ($w = 0; $w <= 21; $w++)
        {
          $longitude[$y][$w] = $cp->longitude[$w];
          $declination[$y][$w] = $cp->declination[$w];
        }

        for ($w = 0; $w <= 9; $w++)
        {
          $house_pos[$y][$w] = $cp->house_pos[$w];
        }     
   
    }
  }

//This is the basic data to calculate the score of the 2 persons , person 0 and person 1.

  $num_MRs = $cp->GetMutualReceptions($longitude[0], $longitude[1]);
  
  // NOTE: dynes[0] = aspect_power and  dynes[1] = harmony - discord

  $dynes = $cp->GetCosmodynes($longitude[0], $declination[0], $house_pos[0], $longitude[1], $declination[1], $house_pos[1], $hob, $mob);
  $total_harmony = $dynes[1] + ($num_MRs * 5); //Score result from the calculations
  
  $ubt=[0,0];
  
  for($x=0;$x<=1;$x++){   
  
        if (($hob[$x]== 12) And ($mob[$x] == 0))
        {
          $ubt[$x] = 1;        // this person has an Unknown Birth Time
        }
  }
    
//PREPARE DATA 

  $cosmodynes_r= Array();
//Store all the values in one object for better access:   
    
  $natal_r=new stdClass();
  $cosmodynes_r["people"]= array([],[]);
//Iterate 
  for ($i=0;$i<=1;$i++)  
  {

    $cosmodynes_r["people"][$i]["name"]=$existing_name[$i];
    $returned_natal=$cp->Get_NatalData($pl_name, $longitude[$i], $declination[$i], $house_pos[$i], $hob[$i], $mob[$i]);
    $cosmodynes_r["people"][$i]["natal"]=$returned_natal;
      
  //natal:
  $natal_r=$cosmodynes_r["people"][$i]["natal"];

        //START DISPLAY PHASE

          //User name:
          Print_r("<H2>");
          Print_r($cosmodynes_r["people"][$i]["name"]);
          Print_r("</H2>");
          Print_r("<br>");
          Print_r("PLANETS<br>");Print_r("<br>");
          Print_r("<br>");
         
        $pl= $natal_r->planets_r; 

       
              for ($t=0;$t<=9;$t++){

                    Print_r("<br>"); Print_r("<br>"); 
                    Print_r("name : ".$pl->name[$t]); 
                    Print_r("<br>"); Print_r("<br>"); 
                    Print_r("decl : ".$pl->decl[$t]); 
                    Print_r("<br>"); Print_r("<br>"); 
                    Print_r("hse : ".$pl->hse[$t]); 
                    Print_r("<br>"); Print_r("<br>");
                    Print_r("------------------------------"); 
                    

                    }
        
         
        Print_r("<br><br>");

        $aspects= $natal_r->aspects_r;
        $midh=$natal_r->aspects_r->midheaven;


        Print_r("HOUSES: ");   
        Print_r("<br>");
        
        Print_r("h1 ascendant: ");
        Print_r($aspects->ascendant);
        Print_r("<br>");
        Print_r("h2 : ");
        Print_r($aspects->house[11]); Print_r("<br>  ");   
        Print_r("h3 : ");
        Print_r($aspects->house[12]); Print_r("<br>  ");
        Print_r("h4 : ");
        Print_r($aspects->house[13]); Print_r("<br>  ");
        Print_r("h5 : ");
        Print_r($aspects->house[14]); Print_r("<br>  ");
        Print_r("h6 : ");
        Print_r($aspects->house[15]); Print_r("<br>  ");
        Print_r("h7 : ");
        Print_r($aspects->house[16]); Print_r("<br>  ");
        Print_r("h8 : ");
        Print_r($aspects->house[17]); Print_r("<br>  ");
        Print_r("h9 : ");
        Print_r($aspects->house[18]); Print_r("<br>  ");
        Print_r("h10 : ");
        Print_r($midh); Print_r("<br>  ");
        Print_r("h11 : ");
        Print_r($aspects->house[20]); Print_r("<br>  ");
        Print_r("h12 : ");
        Print_r($aspects->house[21]); Print_r("<br>  ");

  }


  //For cosmopower score
  $cosmodynes_r["score"]=$total_harmony;
  Print_r("<h1>SCORE</h1><br>");
  Print_r($total_harmony); 
  Print_r("<br>  ");
      
  $jsonData= json_encode($cosmodynes_r);
  $jsonDecoded=json_decode($jsonData);
  echo("<br><br>");  
  print_r($jsonData);    echo("<br><br>");
  var_dump($jsonData);

 
      

foreach($cosmodynes_r["people"][0] as $value) {

        // print_r($value);
        // print_r($value->natal->planets_r->index);
        // print_r($key->name);
    } 
    //  print_r($jsonData->p1->name);
  exit();

