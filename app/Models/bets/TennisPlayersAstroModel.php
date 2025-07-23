<?php

namespace App\Models\bets ;

use CodeIgniter\Model;
use Composer\DependencyResolver\Operation\UninstallOperation;

class TennisPlayersAstroModel extends Model
{
    protected $table = 'TennisPlayersAstro'; // Name of the database table

    protected $primaryKey = 'name'; // Primary key of the tabl
    protected $DBGroup = 'bets';

  //  protected $allowedFields = ['date','name', 'winner_name', 'runnerUp_name', 'titleAvgEloRating']; // Fields that are allowed to be filled
  protected $allowedFields = [
    
           
        'name',
        'ID',
        'HS_Hour',
        'EB_Hour',
        'HS_Day',
        'EB_Day',
        
        'HS_Month',
        'EB_Month',
        'HS_Year',
        'EB_Year',
        'EB_Hour_eng',
      
        'EB_Day_eng',
        'EB_Month_eng',
        'EB_Year_eng',                    
        'Season',
        'Element',                    
        'kin_tone',
        'kin_seal',
        'kin_number',
        'guide_seal',
        'guide_tone',
        'analogue_seal',
        'analogue_tone',
        'antipode_seal',
        'antipode_tone',
        'occult_seal',
        'occult_tone',
        'tribe',
        'a_tribe',
        'sun',
        'moon',                
        'ascendant'];
    protected $useAutoIncrement = true; // Enable auto-increment for the primary key

    protected $returnType = 'array'; // Data return type

    // Additional configuration settings...

    public function __construct()
    {
        parent::__construct();
       
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

        
         public function updateInsertSingle($data){
         
            $db = \Config\Database::connect('bets');
            
            $builder = $db->table($this->table);
            
            try {
                $builder->upsert($data);

                return 1;
            } catch (\Throwable $th) {
                return 0;
            }
         }
        
        



            public function updateFromCSV($csvFilePath)
            {
                // Open the CSV file for reading
                if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
                    // Skip the header row
                    fgetcsv($handle, 1000, ","); // Assuming the header row contains column names

                    // Read the CSV file line by line
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Assuming CSV columns correspond to table columns in order
                        $row = array_combine([
                            
                            'name',
                            'ID',
                            'HS_Hour',
                            'EB_Hour',
                            'HS_Day',
                            'HS_Month',
                            'EB_Month',
                            'HS_Year',
                            'EB_Year',
                            'EB_Hour_eng',
                            'EB_Day',
                            'EB_Day_eng',
                            'EB_Month_eng',
                            'EB_Year_eng',                    
                            'Season',
                            'Element',                    
                            'kin_tone',
                            'kin_seal',
                            'kin_number',
                            'guide_seal',
                            'guide_tone',
                            'analogue_seal',
                            'analogue_tone',
                            'antipode_seal',
                            'antipode_tone',
                            'occult_seal',
                            'occult_tone',
                            'tribe',
                            'a_tribe',
                            'sun',
                            'moon',                
                            'ascendant'], $data); // Adjust column names as per your CSV and table structure

                        // Example: Update record based on primary key
                        $primaryKeyValue = $row['ID']; // Change 'id' to your primary key column name
                        $updateResult=  $this->updateInsertSingle($row);
                    }
                    fclose($handle);
                }
            }



           

            
            public function get_players_astro(){

                $db = \Config\Database::connect('bets');
                $builder = $db->table($this->table);
                
                try {
                    
                   // $builder->select( 'ID,  
                    //name,HS_Hour,EB_Hour,HS_Day,EB_Day,HS_Month,EB_Month,HS_Year,EB_Year,EB_Hour_eng,EB_Day_eng,EB_Month_eng,EB_Year_eng,Season,Element,
                    //kin_tone,kin_seal,kin_number,sun,moon,ascendant');
                    $query = $builder->get();
        
                    return $query->getResult();
                } catch (\Throwable $th) {
                    return 0;
                }    
                
            
            }


   


}