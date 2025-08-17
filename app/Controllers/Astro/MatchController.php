<?php 

namespace App\Controllers\Astro;

use App\Models\User;
use App\Models\UserAstro;
use App\Models\mMatch;
use App\Models\Score;
use App\Models\UserBirth;
use App\Models\UserMatches;
use App\Models\UserInterests;
use App\Controllers\BaseController;

use CodeIgniter\Pager\Pager;

use App\Libraries\astro\match\pMatch;
use App\Libraries\astro\cn\Cn;
use App\Libraries\astro\may\My;
use App\Libraries\astro\zod\Zd;
use App\Libraries\astro\hd\Hd;


class MatchController extends BaseController
{
  protected $user;
	protected $userAstro;
	protected $userMatches;

	protected $userBirth;
	protected $userInterests;
	protected $astro;
	protected $session;	
	protected $match;

    protected $cn;
    protected $my;
    protected $zd;

    protected $hd;
    public function __construct()
    {	helper(['utils', 'form','menu']);
		$this->session=session();
		
		
		//Load models
		$this->user = new User();
		$this->userBirth= new UserBirth();
		$this->userAstro = new UserAstro();       
		$this->userMatches=new UserMatches();
		$this->userInterests=new UserInterests();

	}


	public function index()
	{	
		
		$sessionData = $this->session->getFlashdata('sessionData');
		$this->session->set($sessionData);
		$session=$this->session;
		$data=$this->data;
		//Get top 10 matches
			$userID = $this->session->get('userid');
			$new=$this->user->checkIfNew($userID) ;
		
	//	if ($new){

			//user is new 
		$this->matchhWithAll();   //change to a cron logic in  future  update
		$new=$this->user->setNonfNew($userID) ;
		
	//	}

		//Updates the db match table and the variable BestMatches  
		//$this->matchhWithAll();  


		$bestMatches=$this->bestMatches();

		//prepare matches for display
		$bestMatchesDataArray=$this->prepareMatches($this->getBestMarchesProfileData($bestMatches));



		$data+= [
			'loggedIn' => $session->get('loggedIn'),
			'userid'=> $session->get('userid'),
			'matches'=>$bestMatchesDataArray
		
		];
		$data['seo_title'] = 'Matches';
	return 	view('users/matches', $data) ;
		
	}

	//prepares match data for display in match view
	private function prepareMatches($Best){
		$result=[];
	
		foreach($Best as $match){
			$user=$match["userid"];
			$username=$match["username"];
			$userPic=base_url().PROFILE_PICS_UPLOADS_DIR.$match["profilepicture"];
			$overallScore=$match["Overall_Score"];
			$result[]=["userMatch_userId"=>$user,"MatchScore"=>$overallScore ,"UserMatch_Username"=>$username,"UserMatch_ProfPicture"=>$userPic,
		
			"UserMatch_Age"=>$this->userBirth->getAge($user)];

		}
		return $result;

	}

	//Retrieve matched user basic profile info 
	private function getBestMarchesProfileData($bestMatches){
		$userMatched_Array=[];

	foreach( $bestMatches as $match){
		foreach( $match as $data){
		$userMatched=$this->user->find($data['userb_id']);
		$userMatched["Overall_Score"]=$data["score_total"];
		$userMatched_Array[]=$userMatched;
			}
		
		}
		return $userMatched_Array;
	}
	
	
	//Get best matches for curent user
	private function bestMatches(){
		
		
		
		//Create UserMatches model and use internal model function
		//Cn
		$top10Cn_Values =$this->userMatches->geTop10Matches('Cn',$this->session->get('userid'));
		$best10Matches[]=$top10Cn_Values;
		
		return $best10Matches;

	}
	public function matchhWithAll()
			{
				$userModel = $this->user;
				
				// Get the total number of rows in the 'users' table
				$totalRows = $userModel->countAll();

				// Calculate the chunk size as a percentage of the total number of rows
				$chunkSize = (int) ($totalRows * 0.1); // 10% chunk size
				if ($chunkSize === 0) $chunkSize = 1;

				// Initialize an empty array to store processed users
				$processedUsers = [];
				$MatchedUsers = [];

				$currentUserAstroInfo=$this->userAstro->getAllUserData($this->session->get('userid'));
				$currentUserIsLookinfFor=$this->userInterests->getAllUserData($this->session->get('userid'))['lookingfor'];
				$currentUserSex=$this->user->getAllUserData($this->session->get('userid'))['sex'];

				// Initialize offset
				$offset = 0;
				$currentUserMatches= $this->userMatches;


				$cn_score=0;
				$my__score=0;
				$zd__score=0;
				$hd__score=0;
				$num__score=0;

				do {
					// Fetch users in chunks
					$usersChunk = $userModel->limit($chunkSize, $offset)->findAll();

					// If no users are found, break the loop
					if (empty($usersChunk)) {
						break;
					}



					// Process the data in the chunk
					foreach ($usersChunk as $user) {
						// Process each user

						// Retrieve birth data for each user in chunk
						$Astrohinfo = $this->userAstro->getAllUserData($user['userid']);
						$UserIsLookinfFor=$this->userInterests->getAllUserData($user['userid'])['lookingfor'];
						$UserSex=$this->user->getAllUserData($user['userid'])['sex'];
						
						$prefMatch=$this->preferencesMatchUp($currentUserIsLookinfFor,$currentUserSex,$UserIsLookinfFor,$UserSex);
						$person1=$currentUserAstroInfo;
						$person2=$Astrohinfo;

						//If same user as current user skip
						if($person1['userid']==$person2['userid'])continue;

						//Do match
						if($prefMatch)
						{
						
						$pMatch= new pMatch($person1,$person2 );
						
					
					

									
						}
						else
						//no sex preferences match 
						continue;					

						$matchID=$person1['userid'].'_'.$person2['userid'];

						//Add score to current n
						$Matchdata = [
						'usera_id' =>$person1['userid'],
						'userb_id' => $person2['userid'],
						'matchid' => $matchID,
						
						'score_zd'=> $zd__score,	
					
						'score_total'=>$hd__score+$zd__score

						];
						//save the data to the table
						// make looking for : male  with male looking for  All

						try {
							$currentUserMatches->set($Matchdata);
							$saved = $currentUserMatches->updateInsert($Matchdata,$currentUserMatches);

							if ($saved) {
								// Data saved successfully
								log_message('info', 'Save successful');
						} else {
								log_message('error', 'Error: Save operation failed.');
						}
						} catch (\Exception $e) {
							// Log the exception
							log_message('error', 'Exception occurred during save: ' . $e->getMessage());
						}

						
						
					}

					// Update offset for the next chunk
					$offset += $chunkSize;
				} while (count($usersChunk) === $chunkSize);

				// Load a view to display the processed dat
					




			}
	private function preferencesMatchUp( $CurrnetUserPrefs,$CurrnetUserSex, $OtherUserBprefs,$OtherUserSex ){

		$response="false";

		if ($CurrnetUserSex=="Male"  &&  $OtherUserSex=="Female")
			{

			if ( ( $CurrnetUserPrefs=='Women' ||  $CurrnetUserPrefs=='All') && ( $OtherUserBprefs=='Men' || $OtherUserBprefs=='All')   ){

				return true;
			}
			else
			return false;
			}

		
		 elseif ($CurrnetUserSex=="Female"  &&  $OtherUserSex=="Male")
			{

			if ( ( $CurrnetUserPrefs=='Men' ||  $CurrnetUserPrefs=='All') && ( $OtherUserBprefs=='Women' || $OtherUserBprefs=='All')   ){

				return true;
			}
			else
			return false;
			}
		elseif ($CurrnetUserSex=="Male"  &&  $OtherUserSex=="Male")
			{

			if ( ( $CurrnetUserPrefs=='Men' ||  $CurrnetUserPrefs=='All') && ( $OtherUserBprefs=='Men' || $OtherUserBprefs=='All')   ){

				return true;
			}
			else
			return false;
			}

		elseif ($CurrnetUserSex=="Female"  &&  $OtherUserSex=="Female")
			{

			if ( ( $CurrnetUserPrefs=='Women' ||  $CurrnetUserPrefs=='All') && ( $OtherUserBprefs=='Women' || $OtherUserBprefs=='All')   ){

				return true;
			}
			else
			return false;
		}
		
		else
			return  false;



	}

	private function cn($row)
	{
		$this->cn= new Cn($row);               
	}

	public function get_cn()
	{
		return  $this->cn->get_cn_result_display();        
	}


	public function my($row)
	{
	$this->my= new My($row);
		
	}


	public function get_my()
	{
		return  $this->my->get_my_result_display();        
	}


	public function zd($row)
	{
	$this->zd= new Zd($row);
		
	}


	public function get_zd()
	{
		return  $this->zd->get_zd_result_display();        
	}



	public function hd($row)
	{
		$natal= $this->zd->get_zd_profile();
		$natal88= $this->zd->get_zd_profile_ds();
		$this->hd= new Hd($natal,$natal88);
		
	}
	public function get_hd()
	{
					return  $this->hd->get_hd_result_display();        
	}



}