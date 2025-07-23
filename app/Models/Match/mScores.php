<?php

namespace App\Models\Match;

use CodeIgniter\Model;

class mScores extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'undefined';
	protected $primaryKey       = 'userid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = 	['id','score','compared'];

	// Dates
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
	public function updateScore(string $score_table,array $data)
	{
		// Insert the user data into the database
		// The insert method automatically validates the data (id, score, compared)

		$this->table($score_table)->insert($data);
	
		// Check if the insert was successful
		if ($this->db->affectedRows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function getScore(string $score_table, string $id) {
		// Set the table name dynamically
		$this->table = $score_table;
		
		// Retrieve the score
		$score = $this->where('id', $id)->first();
	
		if ($score) {
			return $score;
		} else {
			// No score found with the specified id
			return null;
		}
	}
	
	
	public function getWeight(string $weights_table, string $id) {
		// Define the SQL select statement
		$sql = "SELECT * FROM {$weights_table} WHERE id = ?";
	
		// Execute the SQL statement
		try {
			$query = $this->db->query($sql, [$id]); // Bind the value separately
			
			// Check if the query was successful
			if ($query) {
				// Fetch the result
				return $query->getRow(); // Assuming you expect only one row
			} else {
				return false; // Query failed
			}
		} catch (\Exception $e) {
			// Handle exceptions if needed
			return false; // Query failed
		}
	}
	

	public function reset_compared($score_table)
	{
		// Get the database instance
		
	
		// Define the SQL update statement
		$sql = "UPDATE {$score_table} SET compared = ?";
	
		// Execute the SQL statement
		try {
			$this->db->query($sql, [0]); // Bind the value separately
			return true; // Update successful
		} catch (\Exception $e) {
			// Handle exceptions if needed
			return false; // Update failed
		}
	}
	

	public function update_compared(string $weights_table,string $id)
	{
		// Get the database instance
		
	
		// Define the SQL update statement
		$sql = "UPDATE {$weights_table} SET compared = ? WHERE id = ?";
	
		// Execute the SQL statement
		try {
			$this->db->query($sql, [1,$id]); // Bind the value separately
			return true; // Update successful
		} catch (\Exception $e) {
			// Handle exceptions if needed
			return false; // Update failed
		}
	}
	


}
