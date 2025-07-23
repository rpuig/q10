<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProf extends BaseModel
{
	protected $DBGroup          = 'default';
	protected $table            = 'userprofinfo';
	protected $primaryKey       = 'userid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = 
	['userid','username','profession', 'position', 'sector'];

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
	
	
	public static $professionOptions = ['Lawyer', 'Tennis Player','Policeman','Yoga teacher', 'Boxer','Doctor', 'Teacher', 'Engineer', 'Tennis Player','Other'];

	public function __construct()
    {
        parent::__construct();
       
    }
	

	public function getAllUserData($userId)
	{
   
	return  $this->where('userid', $userId)->first();
	}



	public function updateUserField($userId, $field, $value)
	{
		log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");
		$result = $this->update($userId, [$field => $value]);
		log_message('debug', "Update result: " . var_export($result, true));
		return $result;
	}


}
