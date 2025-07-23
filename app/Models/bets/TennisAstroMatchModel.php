<?php

namespace App\Models\bets;

use CodeIgniter\Model;

class TennisAstroMatchModel extends Model
{
	protected $DBGroup          = 'bets';
	protected $table            = 'TennisAstroMatch';
	protected $primaryKey       = 'matchID';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [ 'matchID','gameID','winner_ID','defeated_ID','gameID','Winner_Score_Cn',
	'Winner_Score_My'.'Winner_Score_Zd'.'Winner_Score_Num','Winner_Score_Total','Defeated_Score_Cn',
	'Defeated_Score_My'.'Defeated_Score_Zd'.'Defeated_Score_Hd','Defeated_Score_Num',
	'Defeated_Score_Total'];
	
	 	 	 	 	 	 	 	 	 	 	
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	// Other models

	protected $userBirthModel = [];
	

	public function __construct()
    {
        parent::__construct();
       
    }
	public function createMatch(array $matchData)
	{
		// Insert the user data into the database
		// The insert method automatically validates the data against your $
		
		$this->insert($matchData);
	
		// Check if the insert was successful
		if ($this->db->affectedRows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
//Retrieve match data for 2 users



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
					 
					$headers=[                        
						'gameID',
						'matchID',
						'winner_ID',
						'defeated_ID',
						'Winner_Score_Cn',
						'Defeated_Score_Cn',
						'Winner_Score_My',
						'Defeated_Score_My',
						'Winner_Score_Total',
						'Defeated_Score_Total',
						];


						$row = array_combine($headers, $data); // Adjust column names as per your CSV and table structure
					 

					
						$updateResult=  $this->updateInsertSingle($row);
				}
				fclose($handle);
		}
}


}
