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
 
  $id[1] = mysqli_real_escape_string($conn, $_POST["id1"]);
  $id[2] = mysqli_real_escape_string($conn, $_POST["id2"]);
  

  $username = $_SESSION['username'];



  for ($xx = 1; $xx <= 2; $xx++)
  {
    //fetch all data for this record
    $sql = "SELECT * FROM birth_info WHERE ID='$id[$xx]' And entered_by='$username'";
    
    $result =  $db->make_query($conn, $sql);    
    $row = mysqli_fetch_array($result);
    $num_rows = MYSQLI_NUM_rows($result);

    if ($xx == 1)
    {
      $existing_name1 = $row['name'];
    }
    if ($xx == 2)
    {
      $existing_name2 = $row['name'];
    }

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
        $tz = $row['timezone'];
      }
      else
      {
        $tz = "+" . $row['timezone'];
      }

     // echo "BEGIN OF GENERATE RESULT <br>";
       //FOR PERSON 1
      if ($xx == 1)
      {
        $header1 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
        $line1 = $existing_name1 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
       // echo ($line1 );
        
        $cp->CalculatePositions($id[1]);     
      

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
         //FOR PERSON 2
      if ($xx == 2)
      {
        $header2 = '<b>Data for ' . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b><br><br><br>\n", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
        $line2 = $existing_name2 . ", born " . strftime("%A, %B %d, %Y at %X (time zone = GMT $tz hours)</b>", mktime($row['hour'], $row['minute'], $secs, $row['month'], $row['day'], $row['year']));
       // echo ($line2 );
        // assign data from database into arrays for display 
        for ($z = 0; $z <= 21; $z++)
        {
          $pl_name2[$z] = $pl_name1[$z];
        }

           $cp->CalculatePositions($id[2]);

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
  }

//Tis is the basic data to calculate the score
  $num_MRs = $cp->GetMutualReceptions($longitude1, $longitude2);
  $dynes = $cp->GetCosmodynes($longitude1, $declination1, $house_pos1, $longitude2, $declination2, $house_pos2, $hob, $mob);
  $total_harmony = $dynes[1] + ($num_MRs * 5); //Score result from the calculations
  
  $hr_ob = $hob[1];
  $min_ob = $mob[1];

  $ubt1 = 0;
  if (($hr_ob == 12) And ($min_ob == 0))
  {
    $ubt1 = 1;        // this person has an unknown birth time
  }
  $hr_ob = $hob[2];
  $min_ob = $mob[2];

  $ubt2 = 0;
  if (($hr_ob == 12) And ($min_ob == 0))
  {
    $ubt2 = 1;        // this person has an unknown birth time
  }
  
  $cosmodynes_r= Array();
//Store all the values in one object for better access:
    $p = Array();
    $p[0]= Array();
    $p[1]= Array();
    
    $natal_r=new stdClass();

    $cosmodynes_r["people"]= $p;


  //For person 1  //////////////////////////////////////////////////////////////////

  $cosmodynes_r["people"][0]["name"]=$existing_name1;
  $cosmodynes_r["people"][0]["natal"]=$cp->Get_NatalData($pl_name1, $longitude1, $declination1, $house_pos1, $hr_ob, $min_ob);
  
  
  //natal:
  $natal_r=$cosmodynes_r["people"][0]["natal"];

  //User name:
  Print_r("<H2>");
  Print_r($cosmodynes_r["people"][0]["name"]=$existing_name1);
  Print_r("</H2>");
  Print_r("<br>");
  Print_r("PLANETS<br>");Print_r("<br>");
  Print_r("<br>");
  $i=0;
  foreach ($natal_r->planets_r as $value){  
    
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("name : ".$natal_r->planets_r->name[$i]); 
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("decl : ".$natal_r->planets_r->decl[$i]); 
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("hse : ".$natal_r->planets_r->hse[$i]); 
      Print_r("<br>"); Print_r("<br>");
      Print_r("------------------------------"); 
      $i+=1;  

    }
         
  Print_r("<br><br>");
  $aspects= $natal_r->aspects_r;
  $midh=$natal_r->aspects_r->midheaven;
  Print_r("HOUSES: ");   
  Print_r("<br>");
  Print_r("h1: ");
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




 //For person 2//////////////////////////////////////////////////////////////////
 $cosmodynes_r["people"][1]["name"]=$existing_name2;
 $cosmodynes_r["people"][1]["natal"]=$cp->Get_NatalData($pl_name2, $longitude2, $declination2, $house_pos2, $hr_ob, $min_ob);

  //natal:
  $natal_r=$cosmodynes_r["people"][1]["natal"];
 
  //User name:
  Print_r("<H2>");
  Print_r($cosmodynes_r["people"][1]["name"]=$existing_name2);
  Print_r("</H2>");
  Print_r("<br>");
  Print_r("<br>");
  Print_r("PLANETS<br>");Print_r("<br>");
  Print_r("<br>");
  $i=0;
  foreach ($natal_r->planets_r as $value){  
    
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("name : ".$natal_r->planets_r->name[$i]); 
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("decl : ".$natal_r->planets_r->decl[$i]); 
      Print_r("<br>"); Print_r("<br>"); 
      Print_r("hse : ".$natal_r->planets_r->hse[$i]); 
      Print_r("<br>"); Print_r("<br>");
      Print_r("------------------------------"); 
      $i+=1;  

    }
    Print_r("<br><br>");
  $aspects= $natal_r->aspects_r;
  $midh=$natal_r->aspects_r->midheaven;
  Print_r("HOUSES: ");
   
    Print_r("<br>");
    Print_r("h1: ");
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




  //For cosmopower score
 $cosmodynes_r["score"]=$total_harmony;

 Print_r("<h1>SCORE</h1><br>");
 Print_r($total_harmony); Print_r("<br>  ");
    
      $jsonData= json_encode($cosmodynes_r);

      $jsonDecoded=json_decode($jsonData);
      echo("<br><br>");
  
print_r($jsonData);
var_dump($jsonData);

      //var_dump($jsonData );
    //  print_r($jsonData);

    //print_r($cosmodynes_r["score"]);
      

      foreach($cosmodynes_r["people"][0] as $value) {

        // print_r($value);

        // print_r($value->natal->planets_r->index);


        // print_r($key->name);



    }
    //  print_r($jsonData->p1->name);
  exit();

