<?php

namespace App\Models;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class UserBirth extends BaseModel
{
  protected $DBGroup          = 'default';
	protected $table            = 'userbirthinfo';
	protected $primaryKey       = 'userid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields = ['userid', 'sex', 'month', 'birthdate', 'birthtime','unknowntime', 'day', 'year', 'hour', 'minute', 'timezone', 'timezone_txt', 'city','birthcountry','lon','lat','long_deg', 'long_min', 'ew', 'lat_deg', 'lat_min', 'ns',  'long_secs', 'lat_secs'];

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

	public function __construct()
	{	//Access birth info Table
		parent::__construct();
		
	}


	
	public function isBirthProfileEmpty($userID){

		
		$db = \Config\Database::connect();
		$builder = $db->table($this->table);
	
		$builder->where($this->primaryKey, $userID);
		$query = $builder->get();
	
		$result = $query->getRow();
	
		if ($result == null) {
			// User has not yet entered data
			return false;
		} else {
			// User has entered data
			return true;
		}

	}
	
	public function createUserBirth(array $userData)
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
	
	public function initUserBrith($userID )
	{

		$userData = [
			'userid' => 'darth',
			'email'  => 'd.vader@theempire.com',
		];
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
	public function getAge($userId)
	{
		// Retrieve the user's birth information
		$birthInfo = $this->where('userid', $userId)->first();
	
		// Assuming $birthInfo contains 'day', 'month', and 'year' fields
		$birthDate = $birthInfo['year'] . '-' . $birthInfo['month'] . '-' . $birthInfo['day'];
	
		// Create a Time object for the birthdate
		$birthdate = new Time($birthDate);
	
		// Calculate the age
		$today = Time::now();
		$ageInterval = $today->difference($birthdate);
		$age = $ageInterval->getYears();
	
		return -$age;
	}
	
	

	

public function getAllUserData($userId)
{

	$birthInfo= $this->where('userid', $userId)->first();
  $birthInfo=$this->find($userId);
    return  $birthInfo;
}



public function updateUserField($userId, $field, $value)
{
    log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");
    
		$result = $this->update($userId, [$field => $value]);
    
		log_message('debug', "Update result: " . var_export($result, true));
    return $result;
}

}