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

  
        $combined=(object)[];
         // $combined->bday=$pers_2->bd;
         // $combined->btime=$pers_2->bt;     

      }


  
  



  //Only Chinese match Type indicates what type of cn matching will be done 
  
  //reset all compared rows to 0
 
public function matchup(){




}
      
    //Get weights ponderation


  //Compare each castle and apply arbitrary score



 
  /********************COSMODYNES MATCH*********************/

  public function cosmo_match($cos,$db){

   /// $cos->CalculatePositions($id[1]);




    
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