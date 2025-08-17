<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAstro extends BaseModel
{
  protected $DBGroup          = 'default';
	protected $table            = 'userastroinfo';
	protected $primaryKey       = 'userid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;protected $allowedFields = [
    'userid',
    'sun',
    'moon',
    'ascendant'
];

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





public function updateAstro($userId,$zd_data){

	$data=[];

	$data['userid']=$userId;
	//var_dump($zd_data);

	

	$data+=$this->process_zd_data($zd_data);

	
	$db = \Config\Database::connect();
	$existingData  = $db->table('userastroinfo');

		if ($existingData->where('userid', $userId)->get()->getRow()) {
		// Data exists, perform update
		$existingData->where('userid', $userId)
		->update($data);
		} else {
		// Data doesn't exist, perform insert
		$existingData
		->insert($data);
		}
	
}
	
	
public function process_zd_data($zd_data){

	$data=[];
	$planets=(array)$zd_data->planets;

	$aspects=(array)$zd_data->aspects;

	
	$data["sun"]=$aspects["sun"];
	$data["moon"]=$aspects["moon"];
	$data["ascendant"]=$aspects["ascendant"];

	return $data;

}
public function getAllUserData($userId)
{

	$birthInfo= $this->where('userid', $userId)->first();

 
    return  $birthInfo;
}


}