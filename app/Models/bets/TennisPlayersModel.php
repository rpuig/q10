<?php

namespace App\Models\bets ;

use CodeIgniter\Model;
use Composer\DependencyResolver\Operation\UninstallOperation;

class TennisPlayersModel extends Model
{
    protected $table = 'TennisPlayers'; // Name of the database table

    protected $primaryKey = 'ID'; // Primary key of the tabl
    protected $DBGroup = 'bets';

    public bool $isNew;

  protected $allowedFields = [
    'ID',
    'rank',
    'name',
    'country_name',
    'country_id',
    'active',
    'dob',
    'totalPoints',
    'tournamentPoints',
    'rankingPoints',
    'achievementsPoints',
    'tGPoints',
    'tFLPoints',
    'tMPoints',
    'tOPoints',
    'tABPoints',
    'tDTPoints',
    'yearEndRankPoints',
    'bestRankPoints',
    'weeksAtNo1Points',
    'weeksAtEloTopNPoints',
    'bestEloRatingPoints',
    'grandSlamPoints',
    'bigWinsPoints',
    'h2hPoints',
    'recordsPoints',
    'bestSeasonPoints',
    'greatestRivalriesPoints',
    'performancePoints',
    'statisticsPoints',
    'grandSlams',
    'tourFinals',
    'altFinals',
    'masters',
    'olympics',
    'bigTitles',
    'titles',
    'weeksAtNo1',
    'wonLost',
    'bestEloRating',
    'bestEloRatingDate',
    'wonPct'
];  

    protected $useAutoIncrement = true; // Enable auto-increment for the primary key

    protected $returnType = 'array'; // Data return type

    // Additional configuration settings...

    public function __construct()
    {
        parent::__construct();

        $this->isNew=$this->checkIfnew();
       
    }

        public function updateInsert($data){
         
            $db = \Config\Database::connect('bets');
            
            $builder = $db->table($this->table);
            
            try {
                $builder->upsertBatch($data);

                return 1;
            } catch (\Throwable $th) {
                return 0;
            }
         }


    public function checkIfnew(){

            $db = \Config\Database::connect('bets');
            $builder = $db->table('TablesMeta');
            // Build your query
            $query = $builder->select('new')->getwhere(['table_name'=>'TennisPlayers']);
    
            // Execute the query and get the result
            $result = $query->getResult();
    
            // Check if there are any rows matching the criteria
            if (!empty($result)) {
    
                if ($result[0]->new==1)return true;

                else {
                                return false;
                            
                        } 
              
            }

            else return false;
    
    
        }


    
    public function setNotNewBK(){

            $db = \Config\Database::connect('bets');
            $builder = $db->table('TablesMeta');
            // Build your query
            $query = $builder->upsert(['new'=>0,'table_name'=>'TennisPlayers']);
    
            // Execute the query and get the result
          //  $result = $query->getResult();
    
            // Check if there are any rows matching the criteria
            if (!empty($result)) {
    
                if ($result)return true;
                
            } else {
                return false;
              
            }
    
    
        }



    
        public function setNotNew() {
            $db = \Config\Database::connect('bets');
            $builder = $db->table('TablesMeta');
            
            // Build your query with a condition
            $query = $builder->where('table_name', 'TennisPlayers')->update(['new' => 0]);
            
           
            
            // Check if any rows were affected
            if ($query) {
                return true; // Indicates success
            } else {
                return false; // Indicates failure
            }
        }
         
        

    public function get_player_data(){

            $db = \Config\Database::connect('bets');
            $builder = $db->table($this->table);
            
            try {
                
                $builder->select('ID,name,rank,country_name,country_id,active,dob');

                $query = $builder->get();
    
                return $query->getResult();
            } catch (\Throwable $th) {
                return 0;
            }    
            
        
        }


    
   

}