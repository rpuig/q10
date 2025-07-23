<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class People extends Entity{
        protected $name;
        protected $surname;
        protected $bday;
        protected $btime;

        public $planet_pos;
        public $house_pos;
        public $rising;
        public $sun;
        public $moon;

        public $eb_hour;
        public $eb_day;
        public $eb_month;
        public $eb_year;
        public $eb_hour_eng;
        public $eb_day_eng;
        public $eb_month_eng;
        public $eb_year_eng;
        public $hs_hour;
        public $hs_day;
        public $hs_month;
        public $hs_year;

        public $destiny;
        public $guide;
        public $occult;
        public $antipode;
        public $analogue;
        public $tribe;
        public $a_tribe;

        public $dst_number;
        public $lp_number;
        public $lp_group;
        public $sl_number;
        public $dst_number_full;

        public $person_nbr;
        
   
          
        public function __CONSTRUCT($p_order){
             
                        $this->person_nbr=$p_order;

            /*          $this->bday=$combined->bd;
                        $this->btime=$combined->bt;    
                        $this->name=$combined->name;
                        $this->surname=$combined->surname; */
             
                       
                      
                            
        
        
                     
        
              
           
            
        }


        public function getData($variableName) {
                if (property_exists($this, $variableName)) {
                    return $this->$variableName;
                } else {
                    // Handle the case where the variable doesn't exist
                    return null;
                }
            }



        public function setData($combined,$type) {
               
            switch ($type){
                   
                case "cn":
             

                    $this->eb_hour=$combined->eb_hour;
                    $this->eb_day=$combined->eb_day;
                    $this->eb_month=$combined->eb_month;
                    $this->eb_year=$combined->eb_year;

                    $this->eb_hour_eng=$combined->eb_hour_eng;
                    $this->eb_day_eng=$combined->eb_day_eng;
                    $this->eb_month_eng=$combined->eb_month_eng;
                    $this->eb_year_eng=$combined->eb_year_eng; 

                    $this->hs_hour=$combined->hs_hour;
                    $this->hs_day=$combined->hs_day;
                    $this->hs_month=$combined->hs_month;
                    $this->hs_year=$combined->hs_year;     
                    break;
                       

                   
                case "my":

                         
                            
                    $this->destiny=$combined->destiny;
                    $this->guide=$combined->guide;
                    $this->occult=$combined->occult;
                    $this->antipode=$combined->antipode;         
                    $this->analogue=$combined->analogue;   
                    $this->tribe=$combined->tribe;
                    $this->a_tribe=$combined->a_tribe;
                    
                  
                    
                    break;
                        
                        
               
                        
                case "num":                         

                    $this->dst_number=$combined->d_number;
                    $this->lp_number=$combined->lp_number;
                    $this->lp_group=$combined->lp_group;
                    $this->sl_number=$combined->sl_number;   
                    $this->dst_number_full=$combined->dst_number_full;
                                                   
                     break;
                        
                       
                      
                        
                case "cos":

                    


                     break;        

                case "zod":

                     break;
               
                                               
                case "undefined":

                     echo("ERROR : person match type is undefined");

                     break;


                    
           
       }



            }   

}