<?php
namespace App\Libraries\astro\match;
//THIS CLASS HAS THE NECESSARY FUNCTIONS TO CALCULATE DIFFERENT MATCHING FOR GAME BETS



//Include constants needed for matching class like database server log in info
require_once ("m_constants.php");
use App\Controllers\BaseController;

use App\Models\bets\TennisAstroMatchModel;
use App\Models\Match\gScoresModel;
use App\Models\Match\gWeightsModel;


use App\Entities\People;


class gMatch extends BaseController{

  public $type;
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
 
  public function __CONSTRUCT($player,$game, $match_type="undfined"){
          
          $this->type=$match_type;    
          $combined=(object)[];
          $combined->mayan=(object)[];

          switch( $this->type){

          case "cn":
          
          $this->result_object==(object)[];        
          $this->hs_translation_matrix=unserialize(HS_TRANSLATION_MATRIX_ALPHABETICAL);
          $this->eb_translation_matrix=unserialize(EB_TRANSLATION_MATRIX);
        
          $this->scoresModel=new gScoresModel();
          $this->weightsModel=new gWeightsModel();
        
          $this->matchModel=new TennisAstroMatchModel();

          //CREATE  2 people OBJECTS BASED ON THE COMBINED INFORMATION OF EACH PERSON

         
         // $combined->bday=$pers_1->bd;
         // $combined->btime=$pers_1->bt;     

          $combined->eb_hour=$player['EB_Hour'];
          $combined->eb_day=$player['EB_Day'];
          $combined->eb_month=$player['EB_Month'];
          $combined->eb_year=$player['EB_Year'];

          $combined->eb_hour_eng=$player['EB_Hour_eng'];
          $combined->eb_day_eng=$player['EB_Day_eng'];
          $combined->eb_month_eng=$player['EB_Month_eng'];
          $combined->eb_year_eng=$player['EB_Year_eng'];
 
          $combined->hs_hour=$player['HS_Hour'];
          $combined->hs_day=$player['HS_Day'];
          $combined->hs_month=$player['HS_Month'];
          $combined->hs_year=$player['HS_Year'];     

          $this->p_1=new People($combined,1,"cn");  
          
         
         // $combined->bday=$pers_2->bd;
         // $combined->btime=$pers_2->bt;     

          $combined->eb_hour=$game['EB_Hour'];
          $combined->eb_day=$game['EB_Day'];
          $combined->eb_month=$game['EB_Month'];
          $combined->eb_year=$game['EB_Year'];

          $combined->eb_hour_eng=$game['EB_Hour_eng'];
          $combined->eb_day_eng=$game['EB_Day_eng'];
          $combined->eb_month_eng=$game['EB_Month_eng'];
          $combined->eb_year_eng=$game['EB_Year_eng'];

          $combined->hs_hour=$game['HS_Hour'];
          $combined->hs_day=$game['HS_Day'];
          $combined->hs_month=$game['HS_Month'];
          $combined->hs_year=$game['HS_Year'];     


          $this->p_2=new People($combined,2,"cn");   
          
          break;

          case "my":


                  
            $combined->mayan->kin_seal=$player['kin_seal'];
            $combined->mayan->kin_tone=$player['kin_tone'];

            $combined->mayan->guide_seal=$player['guide_seal'];
            $combined->mayan->guide_tone=$player['guide_tone'];
            $combined->mayan->occult_seal=$player['occult_seal'];
            $combined->mayan->occult_tone=$player['occult_tone'];
            $combined->mayan->antipode_seal=$player['antipode_seal'];
            $combined->mayan->antipode_tone=$player['antipode_tone'];

            $combined->mayan->analogue_seal=$player['analogue_seal'];
            $combined->mayan->analogue_tone=$player['analogue_tone'];

            $combined->mayan->tribe=$game['tribe'];
            $combined->mayan->a_tribe=$game['a_tribe'];

            $this->p_1=new People($combined,1,"my");  

            $combined->mayan->kin_seal=$game['kin_seal'];
            $combined->mayan->kin_tone=$game['kin_seal'];

            $combined->mayan->guide_seal=$game['guide_seal'];
            $combined->mayan->guide_tone=$game['guide_tone'];
            $combined->mayan->occult_seal=$game['occult_seal'];
            $combined->mayan->occult_tone=$game['occult_tone'];
            $combined->mayan->antipode_seal=$game['antipode_seal'];
            $combined->mayan->antipode_tone=$game['antipode_tone'];

            $combined->mayan->analogue_seal=$game['analogue_seal'];
            $combined->mayan->analogue_tone=$game['analogue_tone'];

            $combined->mayan->tribe=$game['tribe'];
            $combined->mayan->a_tribe=$game['a_tribe'];

            $this->p_2=new People($combined,1,"my");  
            
            break;

        }
  
      }


  
  



  //Only Chinese match Type indicates what type of cn matching will be done 
  
  //reset all compared rows to 0
 
  public function do_cn_match($type)
    
    {           

                $EB_h1= $this->p_1->getData('eb_hour_eng');
                $EB_d1= $this->p_1->getData('eb_day_eng');
                $EB_m1= $this->p_1->getData('eb_month_eng');
                $EB_y1= $this->p_1->getData('eb_year_eng');
                
                $HS_h1= $this->p_1->getData('hs_hour');
                $HS_d1= $this->p_1->getData('hs_day');
                $HS_m1= $this->p_1->getData('hs_month');
                $HS_y1= $this->p_1->getData('hs_year');
                
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
                  /*only day to other pillar combinations*/ 
                  case "day":

                  // HS DAY COMBINATIONS:  

                  
                  $s_table="match_scores_hs_hs_scores";
                 $this->scoresModel->reset_compared($s_table);              
                
                  //get the HS score per each combination on each day pillar 
                  //First between person2's day HS 
                  $hs_w1=(int)$this->get_weigths("hs_hour","hs_day","hs_day",$s_table);
                  $hs1=(int)$this->get_cn_matrix_score_1to1( $HS_h1 ,  $HS_d2 ,"hs_day" ,$s_table) *  (int)$hs_w1;
                
                  $hs_w2=(int)$this->get_weigths("hs_day","hs_day","hs_day",$s_table);
                  $hs2= (int)$this->get_cn_matrix_score_1to1( $HS_d1 ,  $HS_d2 ,"hs_day" ,$s_table) *  (int)$hs_w2;
                
                // $this->get_cn_matrix_score_1to1( $HS_m1 ,  $HS_d2 ,"hs_day" ) * $this->HS_int_score["hs_month"]["hs_day"]+
                  $hs_w3=(int)$this->get_weigths("hs_year","hs_day","hs_day",$s_table);  
                  $hs3= (int)$this->get_cn_matrix_score_1to1( $HS_y1 ,  $HS_d2 ,"hs_day",$s_table ) *  (int)$hs_w3;
                        
                //Then between person 1's day HS  . The d2 with d1 is omitted a second time to avoid duplicate
                  //$hs_w4=$this->get_weigths("hs_hour","hs_hour","hs_day");
                  //$hs4=$this->get_cn_matrix_score_1to1( $HS_h2 , $HS_h1 ,"hs_day" ) *  $hs_w4;
                  
                  // $this->get_cn_matrix_score_1to1( $HS_m2 , $HS_d1 ,"hs_day" ) * $this->HS_int_score["hs_month"]["hs_day"]+
                  $hs_w5=(int)$this->get_weigths("hs_year","hs_day","hs_day",$s_table);
                  $hs5= (int)$this->get_cn_matrix_score_1to1( $HS_y2 , $HS_d1 ,"hs_day",$s_table ) * (int)$hs_w5;
                  
                  $result_HS=$hs1+$hs2+$hs3+$hs5;

                  // EB DAY COMBINATIONS:


                  $s_table="match_scores_eb_eb_scores";
                  $compared = $this->scoresModel->reset_compared($s_table);
                  
                  //get the EB score per each combination on each day pillar 

                  //First against person 2's day EB  

                  //EBDAY with EBHOUR

                  $eb_w1=(int)$this->get_weigths("eb_hour","eb_day","eb_day",$s_table);
                  $eb1=(int)$this->get_cn_matrix_score_1to1( $EB_h1 , $EB_d2 ,"eb_day",$s_table )*(int) $eb_w1;
                  
                  $eb_w2= (int)$this->get_weigths("eb_day","eb_day","eb_day",$s_table);
                  $eb2= (int)$this->get_cn_matrix_score_1to1( $EB_d1 , $EB_d2 ,"eb_day",$s_table ) *(int) $eb_w2;
                // $this->get_cn_matrix_score_1to1( $EB_m1 , $HS_d2 ,"eb_day" ) * $this->EB_int_score["eb_month"]["eb_day"]+

                  
                  //Then against person 1's day HS  . The d2 with d1 is omitted a second time to avoid duplicate
                  // $eb_w4=  $this->get_weigths("eb_hour","eb_hour","eb_day");
                  //$eb4=$this->get_cn_matrix_score_1to1( $EB_h2 , $EB_h1 ,"eb_day" ) * $eb_w4;

                  //$this->get_cn_matrix_score_1to1( $EB_m2 , $HS_d1 ,"eb_day" ) * $this->EB_int_score["eb_month"]["eb_day"]+
                  
                  //EBDAY with EBYEAR

                  $eb_w3=(int)  $this->get_weigths("eb_year","eb_day","eb_day",$s_table);
                  $eb3=(int)$this->get_cn_matrix_score_1to1( $EB_y1 , $EB_d2 ,"eb_day",$s_table)* (int)$eb_w3 ;                                

                  $eb_w5= (int)$this->get_weigths("eb_year","eb_day","eb_day",$s_table);
                  $eb5=(int)$this->get_cn_matrix_score_1to1( $EB_y2 , $EB_d1 ,"eb_day",$s_table )* (int)$eb_w5 ;

                  $result_EB= $eb1+ $eb2+ $eb3+ $eb5;
                  
                  break;      
                } 
                
                
              $total_score=($result_EB+$result_HS)/2;
              
              return $total_score;
      
      }
    
    
    
    
    

  //gets the scores from database for each possible pillar combination hs or eb 
  private function get_cn_matrix_score_1to1($request_p1,$request_p2,$type,$score_table)
  {
            $score= 0; 
            //Check if we are comparing hs : heavelnly stems or eb:earthly branches  
              
            //reset all compared

            
          //In caser of Hour of Birth unknown 
            if($request_p1==="N/A"||$request_p2==="N/A"){

                        return 0; //score is 0

            }

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
  private function get_weigths($pillar_1,$pillar_2,$type,$score_table)
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

                          
                          
                          
                      
                    
                  }
                
                  return $weight;
    }   
    
    
    
      /********************END CN MATCH*********************/



    /********************MY MATCH*********************/

  
    public function do_my_match($type="undefined"){
          
          
    if($type == "castle")
      {
        
        $pmay1=$this->p_1;
      
        $pmay2=$this->p_2;
        
        //var_dump($pmay1);
      // var_dump($pmay2);
      
      /*Castle comparison*/
        $m_score=$this->do_castle_match($pmay1,$pmay2);
        return $m_score;
        
      }
      else {
        
        echo " There is   not my match,";
        return 0;
      }
      
          
  }

  //Compare each castle and apply arbitrary score

  private function do_castle_match($p1,$p2){
            
      $score=0; 



    //occult destiny relation
        if (($p2->destiny === $p2->occult )|| ($p1->destiny === $p2->occult) ){
        
        $score=$score+2;
      }
     //analogue destiny relation
      if ($p2->destiny === $p1->analogue ||  $p1->destiny=== $p2->analogue  ){
        
        $score=$score+5;
      }  
       //antipode destiny relation
      if ($p2->destiny === $p1->antipode ||  $p1->destiny === $p2->antipode ){
        $score=$score-2;
        
      }  
      //guide destiny relation
      if ($p2->destiny === $p1->guide ||  $p1->destiny === $p2->guide ){
        
        $score=$score+3;
      }
        //destiny destiny relation
      if ($p2->destiny === $p1->destiny ||  $p1->destiny === $p2->destiny  ){
        $score=$score+1;        
      }
      if ($p2->tribe == $p1->tribe   ){
        $score=$score+2;        
      }

      if ($p2->a_tribe === $p1->tribe || $p1->a_tribe === $p2->tribe   ){
        $score=$score+3;        
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

}//end of class