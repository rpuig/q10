<?php
namespace App\Libraries\astro\match;
//THIS CLASS HAS THE NECESSARY FUNCTIONS TO CALCULATE DIFFERENT MATCHING 
//Person class


//Include constants needed for matching class like database server log in info
require_once ("m_constants.php");
use App\Controllers\BaseController;

use App\Models\Match\mMatch;
use App\Models\Match\mScores;
use App\Models\Match\mWeights;

use App\Models\userAstro;

use App\Entities\People;


class pMatch extends BaseController{

  
  public $pers1;  
  public $pers2;
  public $result_object;
  public $chinese_object; 
  public $p_1;
  public $p_2;

  protected $scoresModel;
  protected $weightsModel;
  
   protected $matchModel;

   protected $hs_translation_matrix;
   protected $eb_translation_matrix;


  //INITIALISE MATCH OBJECT VARIABLES
 
  public function __CONSTRUCT($pers_1,$pers_2 ){
          
             
          $this->result_object==(object)[];        
          $this->hs_translation_matrix=unserialize(HS_TRANSLATION_MATRIX_ALPHABETICAL);
          $this->eb_translation_matrix=unserialize(EB_TRANSLATION_MATRIX);
        
          $this->scoresModel=new mScores();
        
          $this->matchModel=new mMatch();
          $this->p_1=new People(1);  
          $this->p_2=new People(2);  
          //CREATE  2 people OBJECTS BASED ON THE COMBINED INFORMATION OF EACH PERSON

          $combined=(object)[];
         // $combined->bday=$pers_1->bd;
         // $combined->btime=$pers_1->bt;     

          $combined->eb_hour=$pers_1['eb_hour'];
          $combined->eb_day=$pers_1['eb_day'];
          $combined->eb_month=$pers_1['eb_month'];
          $combined->eb_year=$pers_1['eb_year'];

          $combined->eb_hour_eng=$pers_1['eb_hour_eng'];
          $combined->eb_day_eng=$pers_1['eb_day_eng'];
          $combined->eb_month_eng=$pers_1['eb_month_eng'];
          $combined->eb_year_eng=$pers_1['eb_year_eng'];
 
          $combined->hs_hour=$pers_1['hs_hour'];
          $combined->hs_day=$pers_1['hs_day'];
          $combined->hs_month=$pers_1['hs_month'];
          $combined->hs_year=$pers_1['hs_year'];   

          $this->p_1->setData($combined,"cn");
         
        $combined=(object)[];
         // $combined->bday=$pers_2->bd;
         // $combined->btime=$pers_2->bt;     

         $combined->eb_hour=$pers_2['eb_hour'];
         $combined->eb_day=$pers_2['eb_day'];
         $combined->eb_month=$pers_2['eb_month'];
         $combined->eb_year=$pers_2['eb_year'];

         $combined->eb_hour_eng=$pers_2['eb_hour_eng'];
         $combined->eb_day_eng=$pers_2['eb_day_eng'];
         $combined->eb_month_eng=$pers_2['eb_month_eng'];
         $combined->eb_year_eng=$pers_2['eb_year_eng'];

         $combined->hs_hour=$pers_2['hs_hour'];
         $combined->hs_day=$pers_2['hs_day'];
         $combined->hs_month=$pers_2['hs_month'];
         $combined->hs_year=$pers_2['hs_year'];     
        
         $this->p_2->setData($combined,"cn");    

         $combined->destiny=$pers_1['kin_tone']." ".$pers_1['kin_seal'];
         $combined->guide=$pers_1['guide_tone']." ".$pers_1['guide_seal'];         
         $combined->occult=$pers_1['occult_tone']." ".$pers_1['occult_seal'];
         $combined->antipode=$pers_1['analogue_tone']." ".$pers_1['antipode_seal'];
         $combined->analogue=$pers_1['analogue_tone']." ".$pers_1['analogue_tone'];
         $combined->a_tribe=$pers_1['a_tribe'];
         $combined->tribe=$pers_1['tribe'];

         $this->p_1->setData($combined,"my");

         $combined->destiny=$pers_2['kin_tone']." ".$pers_1['kin_seal'];
         $combined->guide=$pers_2['guide_tone']." ".$pers_1['guide_seal'];         
         $combined->occult=$pers_2['occult_tone']." ".$pers_1['occult_seal'];
         $combined->antipode=$pers_2['analogue_tone']." ".$pers_1['antipode_seal'];
         $combined->analogue=$pers_2['analogue_tone']." ".$pers_1['analogue_tone'];
         $combined->a_tribe=$pers_2['a_tribe'];
         $combined->tribe=$pers_2['tribe'];

         $this->p_2->setData($combined,"my");
      }


  
  



  //Only Chinese match Type indicates what type of cn matching will be done 
  
  //reset all compared rows to 0
 

  //gets the scores from database for each possible pillar combination hs or eb 
  private function get_cn_matrix_score_1to1($request_p1,$request_p2,$type)
  {
            $score= 0; 
            //Check if we are comparing hs : heavelnly stems or eb:earthly branches  
              
            //reset all compared
          


              switch ($type)
              {
                  /*if hs, get score from the hs score matrix in mysql database */                   
                    
                  /*get score from hs score day to day score matrix in mysql database */
                    case "hs_day":
                    
                      $score_hs_id=$this->hs_translation_matrix[$request_p1][$request_p2]; /*returns id of cross reference  table*/                     
                      $compared=$this->scoresModel->update_compared(HS_SCORE_TABLE,$score_hs_id);                        
                      $score_hs=$this->scoresModel->getScore(HS_SCORE_TABLE,$score_hs_id);       
                      $score= $score_hs;    
                      break;
                    
                    
                    /*get score from eb score matrix  */
                    case "eb_day":                  

                      $score_eb_id=$this->eb_translation_matrix[$request_p1][$request_p2]; /*returns id of cross reference  table*/                     
                      $compared=$this->scoresModel->update_compared(HS_SCORE_TABLE,$score_eb_id);                        
                      $score_eb=$this->scoresModel->getScore(HS_SCORE_TABLE,$score_eb_id);       
                      $score=$score_eb;
                      break;
                  
                } 

              
             
                return $score;
  }   
      /*Get a table with chinese results*/

      
    //Get weights ponderation
  private function get_weigths($pillar_1,$pillar_2,$type)
    {        
      $score= 0; 
      $p1="n/a";$p2="n/a";
 
                //Check if we are comparing hs : heavelnly stems or eb:earthly branches  
                  
                  switch ($type)
                  {
                      /*if hs, get score from the hs score matrix in mysql database */                   
                        
                      /*get score from hs score day to day score matrix in mysql database */
                    case "hs_day":

                        switch($pillar_1){

                          case "hs_hour":  $p1="h";break;
                          case "hs_day":   $p1="d";break;
                          case "hs_month": $p1="m"; break;
                          case "hs_year":  $p1="y";break;                        
        
                         }
                        switch($pillar_2){

                          case "hs_hour":  $p2="h";break;
                          case "hs_day":   $p2="d";break;
                          case "hs_month": $p2="m"; break;
                          case "hs_year":  $p2="y";break;
                      
        
                          }
        
                        
                            $score_hs_id=$p1.$p2; /*returns id of cross reference  table*/  
                                          
                            $table2use=HS_WEIGHTS_TABLE;
                            
                            $sql_query_result=$this->scoresModel->getWeight($table2use,$score_hs_id);
                            $weight=$sql_query_result->score;
                              
                          
                           
                           
                              $compared=  $this->scoresModel->update_compared($table2use,$score_hs_id);
                                  echo ( '<script language="javascript">');
                                  echo ('console.log("compared updated at '.$score_hs_id.' :'.$p1.'  '.$p2.' ")');
    
                                  echo (' </script> ');
                                
 
                            break;
                        
                        
                      /*get score from eb score matrix  */
                      case "eb_day":                  
    

                          switch($pillar_1){
                            case "eb_hour":  $p1="h";break;
                            case "eb_day":   $p1="d";break;
                            case "eb_month": $p1="m"; break;
                            case "eb_year":  $p1="y";break;
                            
          
                          }
                          switch($pillar_2){
                            case "eb_hour":  $p2="h";break;
                            case "eb_day":   $p2="d";break;
                            case "eb_month": $p2="m"; break;
                            case "eb_year":  $p2="y";break;
                        
          
                          }
          
                          
                          $score_eb_id=$p1.$p2; /*returns id of cross reference  table*/                     
                          $table2use=EB_WEIGHTS_TABLE;
                          $sql_query_result=$this->scoresModel->getWeight($table2use,$score_eb_id);
                          $weight=$sql_query_result->score;
                            
                      
                          $compared=  $this->scoresModel->update_compared($table2use,$score_eb_id);
                              echo ( '<script language="javascript">');
                              echo ('console.log("compared updated at '.$score_eb_id.' :'.$p1.'  '.$p2.' ")');

                              echo (' </script> ');

                              break;

                                
                        case "eb_full":    
                                
                            switch($pillar_1){
                              case "eb_hour":  $p1="h";break;
                              case "eb_day":   $p1="d";break;
                              case "eb_month": $p1="m"; break;
                              case "eb_year":  $p1="y";break;
                              
            
                            }
                            switch($pillar_2){
                              case "eb_hour":  $p2="h";break;
                              case "eb_day":   $p2="d";break;
                              case "eb_month": $p2="m"; break;
                              case "eb_year":  $p2="y";break;
                          
            
                            }
                
                                
                          $score_eb_id=$p1.$p2; /*returns id of cross reference  table*/                     
                          $table2use=EB_FULL_WEIGHTS_TABLE;
                          $sql_query_result=$this->scoresModel->getWeight($table2use,$score_eb_id);
                          $weight=$sql_query_result->score;
                            
                      
                          $compared=  $this->scoresModel->update_compared($table2use,$score_eb_id);
                              echo ( '<script language="javascript">');
                              echo ('console.log("compared updated at '.$score_eb_id.' :'.$p1.'  '.$p2.' ")');

                              echo (' </script> ');
                          
                        break;
                          
                        case "hs_full":

                          switch($pillar_1){
  
                            case "hs_hour":  $p1="h";break;
                            case "hs_day":   $p1="d";break;
                            case "hs_month": $p1="m"; break;
                            case "hs_year":  $p1="y";break;                        
          
                           }
                          switch($pillar_2){
  
                            case "hs_hour":  $p2="h";break;
                            case "hs_day":   $p2="d";break;
                            case "hs_month": $p2="m"; break;
                            case "hs_year":  $p2="y";break;
                        
          
                            }
          
                          
                              $score_hs_id=$p1.$p2; /*returns id of cross reference  table*/  
                                            
                              $table2use=HS_FULL_WEIGHTS_TABLE;
                              
                              $sql_query_result=$this->scoresModel->getWeight($table2use,$score_hs_id);
                              $weight=$sql_query_result->score;
                                
                            
                             
                             
                                $compared=  $this->scoresModel->update_compared($table2use,$score_hs_id);
                                    echo ( '<script language="javascript">');
                                    echo ('console.log("compared updated at '.$score_hs_id.' :'.$p1.'  '.$p2.' ")');
      
                                    echo (' </script> ');
                                  
   
                              break;
                    
                  } 
                
                  return $weight;
    }   
  public function do_cn_match($type)
    
    {           
              $full_score=0;
              $day_score=0;       
              $result_EB_tot=0;
              $result_HS_tot=0;
      
      
                $EB_h1= $this->p_1->getData('eb_hour_eng');
                $EB_d1= $this->p_1->getData('eb_day_eng');
                $EB_m1= $this->p_1->getData('eb_month_eng');
                $EB_y1= $this->p_1->getData('eb_year_eng');
                
                $HS_h1= $this->p_1->getData('eb_hour');
                $HS_d1= $this->p_1->getData('eb_day');
                $HS_m1= $this->p_1->getData('eb_month');
                $HS_y1= $this->p_1->getData('eb_year');
                
                $EB_h2= $this->p_2->getData('eb_hour_eng');
                $EB_d2= $this->p_2->getData('eb_day_eng');
                $EB_m2= $this->p_2->getData('eb_month_eng');
                $EB_y2= $this->p_2->getData('eb_year_eng');
                
                $HS_h2= $this->p_2->getData('hs_hour');
                $HS_d2= $this->p_2->getData('hs_day');
                $HS_m2= $this->p_2->getData('hs_month');
                $HS_y2= $this->p_2->getData('hs_year');
      
                
              /* Now we add all the scores from each combination in HS and EB*/
                
                switch ($type){

                  /*only MASTER piLLAR day to other pillar combinations*/ 


                  case "day":              

                  $s_table="match_scores_hs_hs_scores";

                  $this->scoresModel->reset_compared($s_table);              
                  $hs_w1=(int)$this->get_weigths("hs_hour","hs_day","hs_day");
                  
                  if( $HS_h1!="N/A")

                  $hs1=(int)$this->get_cn_matrix_score_1to1( $HS_h1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w1;
                  else $hs1=0;
                
                  $hs_w2=(int)$this->get_weigths("hs_day","hs_day","hs_day");
                  $hs2= (int)$this->get_cn_matrix_score_1to1( $HS_d1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w2;
                  $hs_w3=(int)$this->get_weigths("hs_year","hs_day","hs_day");  
                  $hs3= (int)$this->get_cn_matrix_score_1to1( $HS_y1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w3;
                  $hs_w5=(int)$this->get_weigths("hs_year","hs_day","hs_day");
                  $hs5= (int)$this->get_cn_matrix_score_1to1( $HS_y2 , $HS_d1 ,"hs_day" ) * (int)$hs_w5;
                  $result_HS=$hs1+$hs2+$hs3+$hs5;
                  $s_table="match_scores_eb_eb_scores";
                  $compared = $this->scoresModel->reset_compared($s_table);             
                  if( $EB_h1!="N/A"){
                  $eb_w1=(int)$this->get_weigths("eb_hour","eb_day","eb_day");
                  $eb1=(int)$this->get_cn_matrix_score_1to1( $EB_h1 , $EB_d2 ,"eb_day" )*(int) $eb_w1;}
                  else $eb1=0;
                 
                  $eb_w3=(int)  $this->get_weigths("eb_year","eb_day","eb_day");
                  $eb3=(int)$this->get_cn_matrix_score_1to1( $EB_y1 , $EB_d2 ,"eb_day" )* (int)$eb_w3 ;
                  $eb_w5= (int)$this->get_weigths("eb_year","eb_day","eb_day");
                  $eb5=(int)$this->get_cn_matrix_score_1to1( $EB_y2 , $EB_d1 ,"eb_day" )* (int)$eb_w5 ;
                  $eb_w2= (int)$this->get_weigths("eb_day","eb_day","eb_day");
                  $eb2= (int)$this->get_cn_matrix_score_1to1( $EB_d1 , $EB_d2 ,"eb_day" ) *(int) $eb_w2;
                  $result_EB= $eb1+ $eb2+ $eb3+ $eb5;
                  
                  break;      
                
                  case "full":   

                  $s_table="match_scores_hs_hs_scores";
                  $this->scoresModel->reset_compared($s_table);
                  //get the HS score per each combination on each day pillar 
                  //First between person2's day HS                  
                  $hs_w1=(int)$this->get_weigths("hs_hour","hs_day","hs_full");                   
                  if( $HS_h1!="N/A") 
                  $hs1=(int)$this->get_cn_matrix_score_1to1( $HS_h1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w1;
                  else $hs1=0;
                   
                  $hs_w2=(int)$this->get_weigths("hs_day","hs_day","hs_full");
                  $hs2= (int)$this->get_cn_matrix_score_1to1( $HS_d1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w2;
                  $hs_w3=(int)$this->get_weigths("hs_year","hs_day","hs_full");  
                  $hs3= (int)$this->get_cn_matrix_score_1to1( $HS_y1 ,  $HS_d2 ,"hs_day" ) *  (int)$hs_w3;
                  $hs_w5=(int)$this->get_weigths("hs_year","hs_day","hs_full");
                  $hs5= (int)$this->get_cn_matrix_score_1to1( $HS_y2 , $HS_d1 ,"hs_day" ) * (int)$hs_w5;                         
                  $hs_w4=$this->get_weigths("hs_hour","hs_hour","hs_full");
                  $hs4=$this->get_cn_matrix_score_1to1( $HS_h2 , $HS_h1 ,"hs_day" ) *  $hs_w4;
                  $hs_w6=$this->get_weigths("hs_hour","hs_year","hs_full");
                  $hs6=$this->get_cn_matrix_score_1to1( $HS_h1 , $HS_y2 ,"hs_day" ) *  $hs_w6;
                  $hs_w7=$this->get_weigths("hs_hour","hs_year","hs_full");
                  $hs7=$this->get_cn_matrix_score_1to1( $HS_h2 , $HS_y1 ,"hs_day" ) *  $hs_w7;
                  
                    
                   
                   
                 // $this->get_cn_matrix_score_1to1( $HS_m2 , $HS_d1 ,"hs_day" ) * $this->HS_int_score["hs_month"]["hs_day"]+
                   
                   
                   $result_HS_tot=$hs1+$hs2+$hs3+$hs4+$hs5+$hs6+$hs7;

                  // EB COMBINATIONS:
 
                   $s_table="match_scores_eb_eb_scores";
                   $compared = $this->scoresModel->reset_compared($s_table);
                   
                   //get the EB score per each combination on each day pillar 
 
                   //First against person 2's day EB  

                    // hour-day:
                   $eb_w1=(int)$this->get_weigths("eb_hour","eb_day","eb_full");
 
                   if( $EB_h1!="N/A")
                   $eb1=(int)$this->get_cn_matrix_score_1to1( $EB_h1 , $EB_d2 ,"eb_day" )*(int) $eb_w1;
                   else $eb1=0;
                  
                  // year-day:
                   $eb_w3=(int)  $this->get_weigths("eb_year","eb_day","eb_full");
                   $eb3=(int)$this->get_cn_matrix_score_1to1( $EB_y1 , $EB_d2 ,"eb_day" )* (int)$eb_w3 ;

                  // year-day:
                   $eb_w5= (int)$this->get_weigths("eb_year","eb_day","eb_full");
                   $eb5=(int)$this->get_cn_matrix_score_1to1( $EB_y2 , $EB_d1 ,"eb_day" )* (int)$eb_w5 ;

                   // day-day:
                     
                   $eb_w2= (int)$this->get_weigths("eb_day","eb_day","eb_full");
                   $eb2= (int)$this->get_cn_matrix_score_1to1( $EB_d1 , $EB_d2 ,"eb_day" ) *(int) $eb_w2;
                    // $this->get_cn_matrix_score_1to1( $EB_m1 , $HS_d2 ,"eb_day" ) * $this->EB_int_score["eb_month"]["eb_day"]+
                  
                  
                  // hour-day:                 
                  $eb_w4=(int)  $this->get_weigths("eb_hour","eb_hour","eb_full");
                  $eb4=(int)$this->get_cn_matrix_score_1to1( $EB_h1 , $EB_y2 ,"eb_day" )* (int)$eb_w4 ;
                
                  // year-day:
                  $eb_w6= (int)$this->get_weigths("eb_year","eb_day","eb_full");
                  $eb6=(int)$this->get_cn_matrix_score_1to1( $EB_y2 , $EB_d1 ,"eb_day")* (int)$eb_w6 ;

                   // hour-hour:
                  $eb_w7=  $this->get_weigths("eb_hour","eb_hour","eb_full");
                  $eb7=$this->get_cn_matrix_score_1to1( $EB_h2 , $EB_h1 ,"eb_day" ) * $eb_w4;
    
                  $result_EB_tot= $eb1+ $eb2+ $eb3+ $eb4 + $eb5 +$eb6 ;
                   
                  break;   
                
                } 
                
                
              $day_score=($result_EB+$result_HS)/2; 
              $full_score=($result_EB_tot+$result_HS_tot)/2;
              $result=$type=="day"? $day_score:$full_score;
              
              return $result;
      
      }

  private function cn_harmony(){









  } 
    
    /********************END CN MATCH*********************/



    /********************MY MATCH*********************/

  
    public function do_my_match($type){
          
          
    if($type == "my_simple")
      {
        
        $pmay1=$this->p_1;
      
        $pmay2=$this->p_2;
        
        //var_dump($pmay1);
      // var_dump($pmay2);
      
      /*Castle comparison*/
        $m_score=$this->do_castle_match("simple");
        return $m_score;
        
      }
      else {
        
        echo " There is   not my match,";
        return 0;
      }
      
          
  }

  //Compare each castle and apply arbitrary score

  private function do_castle_match($type){
            
      $score=0; 


      switch ($type){


        case "simple":


              //occult destiny relation
              if ($this->p_2->destiny == $this->p_2->occult || $this->p_1->destiny == $this->p_2->occult ){
                
                $score=$score+2;
              }
            //analogue destiny relation
              if ($this->p_2->destiny == $this->p_1->analogue ||  $this->p_1->destiny == $this->p_2->analogue  ){
                
                $score=$score+5;
              }  
              //antipode destiny relation
              if ($this->p_2->destiny == $this->p_1->antipode ||  $this->p_1->destiny == $this->p_2->antipode ){
                $score=$score-2;
                
              }  
              //guide destiny relation
              if ($this->p_2->destiny == $this->p_1->guide ||  $this->p_1->destiny == $this->p_2->guide ){
                
                $score=$score+3;
              }
                //destiny destiny relation
              if ($this->p_2->destiny == $this->p_1->destiny ||  $this->p_1->destiny == $this->p_2->destiny  ){
                $score=$score+1;       

               }       
      

          break;


          case "dreamspell":          

            $score=1;

            break;

      }
      
      
      
      return $score;
      }




  // public function seal_comp(){  }

  // public function tone_comp(){}

  // public function castle_conp(){}

  /********************COSMODYNES MATCH*********************/

  public function cosmo_match($cos,$db){

   /// $cos->CalculatePositions($id[1]);




    
  }

  public function num_match(){



    
  }


  public function zd_match($p1,$p2){

    /// $cos->CalculatePositions($id[1]);
 
 //moon-sun


 $pi_moon="";
 $pi_sun="";
 $pi_asc="";

 $p2_moon="";
 $p2_sun="";
 $p2_asc="";



 //moon-moon

 //asc-sun

 //sun-sun



 
 
     
   }


  }//end of class