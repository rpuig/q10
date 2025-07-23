<?php

namespace App\Models\Match;

use CodeIgniter\Model;

class mMatch extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 'matches';
	protected $primaryKey       = 'matchID';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['userA_ID','userB_ID', 'matchID','Score_Cn','Score_My'.'Score_Zd'.'Score_Hd','Score_Num'];
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
	
	public static $sexOptions = ['Male', 'Female', 'Other'];
	public static $professionOptions = ['Lawyer', 'Policeman', 'Doctor', 'Teacher', 'Engineer', 'Other'];

	public function __construct()
    {
        parent::__construct();
       
    }
	public function createMatch(array $userData)
	{
		// Insert the user data into the database
		// The insert method automatically validates the data against your $
		
		$this->insert($userData);
	
		// Check if the insert was successful
		if ($this->db->affectedRows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
//Retrieve match data for 2 users
	public function getMatchData($userA,$userB)
{
   
	return  $this->where('matchID', $userA)->first().'_'.$userB->first();
}




public function updateUserField($userId, $field, $value)
{
    log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");
    $result = $this->update($userId, [$field => $value]);
    log_message('debug', "Update result: " . var_export($result, true));
    return $result;
}
}
