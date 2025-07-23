<?php

namespace App\Models\bets ;

use CodeIgniter\Model;
use Composer\DependencyResolver\Operation\UninstallOperation;

class TennisGamesModel extends Model
{
    protected $table = 'TennisGames'; // Name of the database table

    protected $primaryKey = 'gameID'; // Primary key of the tabl
    protected $DBGroup = 'bets';


    public bool $isNew=false;

  protected $allowedFields = [
    'ID',
    'gameID'.
    'season',
    'date',
    'name',
    'level',
    'surface',
    'indoor',
    'drawType',
    'drawSize',
    'playerCount',
    'participation',
    'strength',
    'AvgEloRating',
    'winner_name',
    'winner_seed',
    'winner_country_name',
    'winner_country_id',
    'runnerUp_name',
    'runnerUp_seed',
    'runnerUp_country_name',
    'runnerUp_country_id',
    'score',
    'titleDifficulty',
    'titleAvgRank',
    'titleAvgEloRating',
    'speed',
    'outcome',
];
    protected $useAutoIncrement = true; // Enable auto-increment for the primary key

    protected $returnType = 'array'; // Data return type

    // Additional configuration settings...

    public function __construct()
    {
        parent::__construct();


        $this->isNew=$this->checkIfnew();
       
    }


    

    public function checkIfnew(){

        $db = \Config\Database::connect('bets');
        $builder = $db->table('TablesMeta');
        // Build your query
        $query = $builder->select('new')->getwhere(['table_name'=>'TennisGames']);

        // Execute the query and get the result
        $result = $query->getResult();

        // Check if there are any rows matching the criteria
        if (!empty($result)) {

            if ($result[0]->new==1)return true;

            else {
                            return false;
                        
                    } 
          
        }

        else 
        return false;


    }



    public function setNotNewBK(){

        $db = \Config\Database::connect('bets');
        $builder = $db->table('TablesMeta');
        // Build your query
        $query = $builder->upsert(['new'=>0,'table_name'=>'TennisGames']);

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
        $query = $builder->where('table_name', 'TennisGames')->update(['new' => 0]);
        
       

        if ($query) {
            // Update successful and rows affected
            return true;
        } else {
            // Update might have failed or no rows affected
            return false;
        }
    }
    



    public function updateInsert($data){
         
            $db = \Config\Database::connect('bets');
            $builder = $db->table($this->table);
            
            try {
                $builder->upsertBatch($data);

                $this->setnew();//set new as false as talbe has been filled up and data is not new anymore


                return 1;
            } catch (\Throwable $th) {
                return 0;
            }
    }


    public function get_game_data(){

        $db = \Config\Database::connect('bets');
        $builder = $db->table($this->table);
        
        try {
            
            $builder->select('ID,gameID,date,winner_name,runnerUp_name');
            $query = $builder->get();

            return $query->getResult();
        } catch (\Throwable $th) {
            return 0;
        }    
        
    
    }
        

    public function get_game_Name(){

        $db = \Config\Database::connect('bets');
        $builder = $db->table($this->table);
        
        try {
            
            $builder->select('name');
            $query = $builder->get(1,1);

            return $query->getResult();
        } catch (\Throwable $th) {
            return 0;
        }    
        
    
    }
    
    

}