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
    'hs_hour',
    'eb_hour',
    'hs_day',
    'eb_day',
    'hs_month',
    'eb_month',
    'hs_year',
    'eb_year',
    'eb_hour_eng',
    'eb_day_eng',
    'eb_month_eng',
    'eb_year_eng',
    'season',
    'element',
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





public function updateAstro($userId,$cn_data,$my_data,$zd_data){

	$data=[];

	$data['userid']=$userId;
	//var_dump($zd_data);
	$data['hs_hour']=$cn_data->HS_Hour;
	$data['eb_hour']=$cn_data->EB_Hour;
	$data['eb_hour_eng']=$cn_data->EB_Hour_eng;
	
	$data['hs_day']=$cn_data->HS_Day;
	$data['eb_day']=$cn_data->EB_Day;
	$data['eb_day_eng']=$cn_data->EB_Day_eng;

	$data['hs_month']=$cn_data->HS_Month;
	$data['eb_month']=$cn_data->EB_Month;
	$data['eb_month_eng']=$cn_data->EB_Month_eng;

	$data['hs_year']=$cn_data->HS_Year;
	$data['eb_year']=$cn_data->EB_Year;
	$data['eb_year_eng']=$cn_data->EB_Year_eng;


	$data['season']=$cn_data->Season;
	$data['element']=$cn_data->element_prof;

	$data['kin_seal']=$my_data->kin_seal;
	$data['kin_tone']=$my_data->kin_tone;
	$data['kin_number']=$my_data->kin_number;

	$data['guide_seal']=$my_data->guide_seal;
	$data['guide_tone']=$my_data->guide_tone;
	$data['analogue_seal']=$my_data->analogue_seal;
	$data['analogue_tone']=$my_data->analogue_tone;
	$data['antipode_seal']=$my_data->antipode_seal;
	$data['antipode_tone']=$my_data->antipode_tone;
	$data['occult_seal']=$my_data->occult_seal;
	$data['occult_tone']=$my_data->occult_tone;
	$data['tribe']=$my_data->tribe;
	$data['a_tribe']=$my_data->a_tribe;

	

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