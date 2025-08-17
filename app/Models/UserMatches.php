<?php

namespace App\Models;
use CodeIgniter\Model;
	use App\Models\BaseModel;
use App\Controllers\Utils\QueryLogger;

class UserMatches extends BaseModel
{
  protected $DBGroup         	= 'default';
	protected $table            = 'usermatches';
	protected $primaryKey       = 'matchid';
	protected $useAutoIncrement = true; 
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields = ['userid','usera_id','matchid','userb_id','score_cn','score_my','score_zd','score_hd','score_num','score_total'];
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




// get total score

public function getAllMatchScore($userID){

$row=$this->findAll->where($userID);


}

public function geTop10Matches($type,$usrID){
	$currentUserID=$usrID;

	switch ($type) {
		case 'Cn':
			$results=$this->where('usera_id =', $currentUserID)->orderBy('score_cn', 'desc')->findAll(10);
			break;

		case 'My':
				$results=$this->where('usera_id =', $currentUserID)->orderBy('score_my', 'desc')->findAll(10);
			break;

		case 'Zd':
				$results=$this->where('usera_id =', $currentUserID)->orderBy('score_zd', 'desc')->findAll(10);
			break;
		case 'Hd':
				$results=$this->where('usera_id =', $currentUserID)->orderBy('score_hd', 'desc')->findAll(10);
		break;		
		
		case 'Num':
			$results=$this->where('usera_id =', $currentUserID)->orderBy('score_num', 'desc')->findAll(10);
		break;		
		
		default:
			$results=$this->where('usera_id =', $currentUserID)->orderBy('B', 'desc')->findAll(10);
			break;
	}

	return $results;

	
	}
	


// get top 10 scores for usr based on userID provided

//get newest scores based on updated time


public function updateInsert($Matchdata, $currentUserMatches)
{
    try {
        $matchID = $Matchdata['matchid'];

        if (!$matchID) {
            throw new \Exception('Matchdata must contain a matchid.');
        }

        // Log incoming data for debugging
        log_message('debug', 'Received Matchdata: ' . json_encode($Matchdata));

        // Check if a record with the given matchID exists
        $existingRecord = $currentUserMatches->where('matchid', $matchID)->get()->getRow();

        if ($existingRecord) {
            // Update existing record
            log_message('debug', "Updating record with matchid: {$matchID}");
            $ql = new QueryLogger();
            $currentUserMatches->where('matchid', $matchID)->set($Matchdata)->update();
            $ql->logLastQuery();

            // Log affected rows
            log_message('debug', 'Update query affected rows: ' . $this->db->affectedRows());
        } else {
            // Insert new record
            log_message('debug', "Inserting new record with matchid: {$matchID}");
            $currentUserMatches->insert($Matchdata);

            // Log last query
            log_message('debug', 'Insert query executed: ' . $currentUserMatches->getLastQuery());

            // Log affected rows
            log_message('debug', 'Insert query affected rows: ' . $this->db->affectedRows());
        }

        // Check if the operation was successful
        $saved = ($this->db->affectedRows() > 0);

        if ($saved) {
            log_message('info', "Operation successful for matchid: {$matchID}");
            return true;
        } else {
            log_message('warning', "No rows affected for matchid: {$matchID}. Possible duplicate or unchanged data.");
            return false;
        }
    } catch (\Exception $e) {
        // Log the exception with stack trace
        log_message('error', 'Exception occurred during save: ' . $e->getMessage());
        log_message('debug', 'Exception Trace: ' . $e->getTraceAsString());
    }

    return false;
}

	
public function deleteAllamatchesB($userID){
	$db= $this->db;
	$rgx = '^' . $userID . '.*';
	$rgx = '.*' . $userID . '.*';
	//$sql = 'SELECT * FROM ' . $this->table . ' WHERE matchID REGEXP \'' . $rgx . '\'';
	
   
  //  $query = $db->table($this->table)->like('matchID', $rgx, 'regex')->delete();
    $query = $db->table($this->table)->where("matchid REGEXP '$rgx'")->delete();
return  $query;



}



public function deleteAllMatches($userID) {
	$db = $this->db;

	// Regex pattern to match userID
	$rgx = '^' . $userID . '.*';  // Matches strings starting with userID
	
	// Use the query builder's `where()` method with raw SQL
	$query = $db->table($this->table)
							->where("matchid ~ '$rgx'", null, false)  // Use raw SQL for the regex condition
							->delete();
	
	return $query;
}


}