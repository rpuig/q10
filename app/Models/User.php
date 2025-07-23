<?php
	
namespace App\Models;

use CodeIgniter\Model;

class User extends BaseModel
{

	protected $table            = 'users';
	protected $primaryKey       = 'userid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;


	protected $allowedFields = [
    'username', 'new', 'email', 'password', 'language', 'verification_token', 'is_active',
    'verification_code', 'profilepicture', 'name', 'surname', 'element', 'sex',
    'aboutme', 'data_visibility'
];

	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';

	protected $deletedField  = 'deleted_at'; // Optional, define field name
	

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


	public function __construct()



    {

$this->primaryKey="userid";

        parent::__construct();
       
    }



	public function createUser(array $userData)
	{
			try {
					$result = $this->insert($userData);
					
					// Log the last query
					log_message('debug', 'Last query: ' . $this->db->getLastQuery());
					
					if ($result === false) {
							log_message('error', 'Failed to insert user: ' . print_r($this->errors(), true));
							return false;
					}
					
					$insertedId = $this->insertID();
					log_message('info', 'User created with ID: ' . $insertedId);
					
					return $insertedId;
			} catch (\Exception $e) {
					log_message('error', 'Exception when creating user: ' . $e->getMessage());
					log_message('error', 'Exception trace: ' . $e->getTraceAsString());
					return false;
			}
	}
	public function getUserByUsername($username) {
		//$sql = "SELECT * FROM Users WHERE username = ?";
//$user = $this->query($sql, [$username])->getRow();
		$user = $this->where('username', $username)->first();

		if ($user) {
			return $user;
		} else {
			// No user found with the specified username
			return null;
		}
	}

	public function getAllUserData($userId)
	{
		// Step 1: Validate the user ID
		if (!$userId) {
			// Handle invalid user ID, for example:
			return null; // or throw an InvalidArgumentException
		}
	
		// Step 2: Execute the query
		try {
			$userData = $this->where('userid', $userId)->first();
			
			// Step 3: Check if the query executed successfully
			if (!$userData) {
				// Handle case when user data is not found
				return null; // or throw an Exception
			}
	
			// Return the retrieved user data
			return $userData;
		} catch (\Exception $e) {
			// Step 4: Handle any potential errors
			// Log the error or return an appropriate error message
			// For example:
			return null; // or throw a custom exception
		}
	}
	

	public function checkIfNew($userId)
{
    $result = $this->select('new')->where('userid', $userId)->first();

    // Check if 'new' field is set to 1
    if ( $result["new"] == 1) {
        return true;
    } else {
        return false;
    }
}
	//sets new to 0 for non new users
	public function setNonfNew($userId)
	{
		$result = $this->select('new')->where('userid', $userId)->first();
		
		// Ensure $result is not empty and 'new' value exists
		if (!empty($result) && (int)$result['new'] === 1) {
	
			$data = [
				'new' => 0,
			];
			$this->update($userId, $data);
		}
		return 1;
	}


	public function setAsNew($userId)
	{
		$result = $this->select('new')->where('userid', $userId)->first();
		
		// Ensure $result is not empty and 'new' value exists
		if (!empty($result) && (int)$result['new'] === 0) {
	
			$data = [
				'new' => 1,
			];
			$this->update($userId, $data);
		}
		return 1;
	}

	public function getAllUserProfilePicture($userId)
	{
		$user=$this->where('userid', $userId)->first();
		$profilePicture=$user['profilepicture'];

	return  $profilePicture;
	}




public function updateUserField($userId, $field, $value)
{
    log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");

	$data = [
		'userid'  => $userId,
		$field => $value
		
	];
    $result = $this->save($data);
    log_message('debug', "Update result: " . var_export($result, true));
    return $result;
}



public function softDelete(int $userId)
{
	$currentTime = strtotime(date('Y-m-d H:i:s'));
	$this->update($userId, ['deleted_at' => $currentTime]);
}



public function getAllMessages(){


return $this->findAll();



}


}
