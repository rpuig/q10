<?php 

namespace App\Controllers;

use App\Controllers\Astro\MatchController;
use App\Models\User;
use App\Models\UserBirth;
use App\Models\UserProf;
use App\Models\UserInterests;


class ProfileController extends BaseController
{
  protected $user;
	protected $userBirth;

	protected $userProf;//for user professoio related things 
	protected $astro;
	
	protected $userInterests;
	protected $validation;
    public function __construct()
    {		
	
		parent::__construct();
		
	
		//Load models
		$this->userBirth = new UserBirth();
   		$this->user = new User();
		$this->userProf = new UserProf();// For user professional information
		$this->userInterests = new UserInterests();		


    }

		public function switchLanguage($lang)
    {
        // Set the language in session
        $session = session();
        $session->set('language', $lang);

        // Return a response (JSON or redirect)
        return $this->response->setJSON(['success' => true]);
    }
	public function index()
	{
	$geo=new GeoCodeController();
	//$geo->getGoogleLatLng(); //replace with somethihg free
	
	$data=$this->data;

		// Check if a language is set in the session, else use default language (en)
		$language = $this->session->get('language') ?? 'en';

		// Set the language in the language service
		$languageService = service('language');
		$languageService->setLocale($language);

		// Load the language helper
		helper('language');

		$data['seo_title'] = 'Profile';


		if (session('loggedIn')==1) {
			
			$data['user'] = $this->user->getAllUserData($data['userid']);
			$data['user']['birthInfo']= $this->userBirth->getAllUserData($data['userid']);
			$data['user']['birthInfo']!=NULL? $data['user']['birthInfo']['birthdate']=$data['user']['birthInfo']['day'].'/'.$data['user']['birthInfo']['month'].'/'.$data['user']['birthInfo']['year']:
			$data['user']['birthInfo']['birthdate']="dd/mm/aaaa";
			
			$this->userBirth->getAllUserData($data['userid']);
			

			$data['user']['profinfo']= $this->userProf->getAllUserData($data['userid']);
			$data['user']['interests']['lookingfor']= $this->userInterests->getAllUserData($data['userid']);
			
			$data['username']= $data['user']['username'];
			$data['userId' ]=  $data['user']['userid'];
			$data['surname' ]=  $data['user']['surname'];
			$data['name' ]=  $data['user']['name'];
			$data['sex' ]=  $data['user']['sex'];

			$data['lookingFor' ]=  $data['user']['interests']['lookingfor'];

			$data['aboutMe' ]=  $data['user']['aboutme'];
			$data['profession' ]=  $data['user']['profinfo']['profession'];
			$data['birthdate' ]=  $data['user']['birthInfo']['birthdate'];
			
			
			$data['user']['birthInfo']!=NULL? $data['birthtime' ]=$data['user']['birthInfo']['birthtime']: $data['birthTime']="";

			$data['visibility_settings' ]=  $data['user']['data_visibility'];

			$data['city' ]=  $data['user']['birthInfo']['city'];
			$data['birthcountry' ]= $data['user']['birthInfo']['birthcountry'];
			$data['timezone' ]= $data['user']['birthInfo']['timezone_txt'];
			$data ['profpicture']=$this->getProfilePicture($data['userid']);
			$data ['unknownTime']=	$data['user']['birthInfo']['unknowntime'];
			session()->set('sessiondata',$data);

			return	view('users/profile', $data) ;
			
		}	
//not yet taken into account as user needs to be logged in to see matches
		else{
		//	$data['loggedIn']=true;
			
		
	
			return 	view('users/login', $data) ;


		}
		
		
	
		
		
	}


//Return public profile 

	public function publicProfile($userID=NULL)
	{
		$userID= $this->request->getVar('userID');

		$data=$this->data;
		$data['seo_title'] = 'Profile';
		

		if ($data['loggedIn']) {

			//Return own user public profile in preview as no other id is specified 
			if($userID==NULL){
				
			$data['user'] = $this->user->getAllUserData($data['userid']);
			$data['user']['birthInfo']= $this->userBirth->getAllUserData($data['userid']);
			$data['user']['profinfo']= $this->userProf->getAllUserData($data['userid']);
			$data['user']['interests']= $this->userInterests->getAllUserData($data['userid']);

			$data['visibility']=$data['user']['data_visibility'];
			$data  ['username']= $data['user']['username'];
			$data  ['userid' ]=  $data['user']['userid'];
			$data  ['surname' ]=  $data['user']['surname'];
			$data  ['name' ]=  $data['user']['name'];
			$data  ['sex' ]=  $data['user']['sex'];
			$data  ['lookingfor' ]=  $data['user']['interests']['lookingfor'];
			$data  ['aboutme' ]=  $data['user']['aboutme'];		
			$data  ['profession' ]=  $data['user']['profinfo']['profession'];
			$data  ['birthdate' ]=  $data['user']['birthInfo']['birthdate'];
			$data  ['birthtime' ]=  $data['user']['birthInfo']['birthtime'];
			$data  ['city' ]=  $data['user']['birthInfo']['city'];
			$data  ['birthcountry' ]=  $data['user']['birthInfo']['birthcountry'];
			$data  ['profilepicture']=$this->getProfilePicture($data['userid']);
			$data['message_btn']=false;
			
			}

			else{ //Return another user public profile, i.e. when clicking on a match card

			$data['user'] = $this->user->getAllUserData($userID);
			$data['user']['birthInfo']= $this->userBirth->getAllUserData($userID);
			$data['user']['profinfo']= $this->userProf->getAllUserData($userID);
			$data['user']['interests']= $this->userInterests->getAllUserData($userID);
			$data['userid']=$userID;
			$data['visibility']=$data['user']['data_visibility'];
			$data  ['username']= $data['user']['username'];
			$data  ['userId' ]=  $data['user']['userid'];
			$data  ['surname' ]=  $data['user']['surname'];
			$data  ['name' ]=  $data['user']['name'];
			$data  ['sex' ]=  $data['user']['sex'];
			$data  ['lookingfor' ]=  $data['user']['interests']['lookingfor'];
			$data  ['aboutme' ]=  $data['user']['aboutme'];		
			$data  ['profession' ]=  $data['user']['profinfo']['profession'];
			$data  ['birthdate' ]=  $data['user']['birthInfo']['birthdate'];
			$data  ['birthtime' ]=  $data['user']['birthInfo']['birthtime'];
			$data  ['city' ]=  $data['user']['birthInfo']['city'];
			$data  ['birthcountry' ]=  $data['user']['birthInfo']['birthcountry'];
			$data  ['profilepicture']=$this->getProfilePicture($data['userid']);
			$data['message_btn']=true;


			}
		}
		
		
		return 
		
	
		view('users/public_profile', $data) ;
		
		
	}
	//Update profile with post values

	private function getUserCurrentUserName()
    {
        // Retrieve the current user's ID or any other identifier based on your authentication logic
        $userid =  $this->request->getPost('userid'); // Example: Retrieve user ID from session

        // Fetch the user data from the UserModel based on the user ID
        $user = $this->user->find($userid);

        // Check if user exists and return the username if available, otherwise return null
        return $user ? $user['username'] : null;
    }
	public function UpdateUserSettings()
		{
			$this->validation = service('validation');
			$rules=[
				
				'email' => 'valid_email|is_unique[users.email]',
				'password' => 'permit_empty|min_length[6]',
				// Add common sense rules for other fields
				'userid' => 'numeric|greater_than[0]', // Positive numeric value

				];
	
			$this->validation->setRules($rules);
			$validating=$this->validate($this->validation->getRules());

			if ($validating) {

				// Validation passed, proceed with further actions
				$userId = $this->request->getPost('userid');
				$sex = $this->request->getPost('email');
				$profession = $this->request->getPost('password');
	
				$this->updateUserF($userId, 'email', $sex);
				$this->updateUserF($userId, 'password', $profession);
				
			
			} else {
				// Validation failed, handle errors
				$errors = $this->validation->getErrors();
				return redirect()->back()->withInput()->with('errors', $errors);
				// Handle errors, like displaying them to the user or logging
			}
		
			return redirect()->to('/settings');
		}
		
	public function UserSettings(){
		$data=$this->data;
		$data['seo_title']="settings";
		$data['user'] = $this->user->getAllUserData($data['userid']);
		$data["password"]=$data['user']['password'];
		$data["email"]=$data['user']['email'];

		return view('users/settings',$data);
	
	}

	
			
		
	
	public function uploadProfilePicture()
	{
   
		$profilePicture = $this->request->getFile('profilepicture');

		var_dump($profilePicture->getSize());

			try {
				$file = $profilePicture;
		
				if ($file->isValid() && !$file->hasMoved()) {
					$newName = $file->getRandomName();
					$file->move(FCPATH . 'assets/uploads/user_profile_images', $newName);
		
					// Get the user ID from the form
					$userId = $this->request->getPost('userid');
		
					// Update the user's profile picture
					$updateResult = $this->user->update($userId, ['profilepicture' => $newName]);
		
					if ($updateResult === false) {
						// The update method will return false if the data failed to validate or the update failed
						// You can get the error messages from the model
						$errors = $this->user->errors();
						return redirect()->back()->with('errors', $errors);
					} else {
						// The update was successful
						// Add the new picture name and path to the session data
						session()->set('profilepicture', base_url('assets/uploads/user_profile_images/' . $newName));
						return redirect()->to('/profile')->with('message', 'Profile picture updated successfully');
					}
				}
			} catch (\Exception $e) {
				// An exception occurred
				$errors = $this->validation->getErrors();
				return redirect()->to('/profile')->withInput()->with('errors', $errors);
			}
		
	}

	public function getProfilePicture($id)

	{
		
		$profPictureURL= PROFILE_PICS_UPLOADS_DIR.$this->user->getAllUserProfilePicture($id);
		$profPictureURL=base_url($profPictureURL);
		return $profPictureURL;

	}


	public function updateLanguage()
	{
			$data = $this->request->getJSON(); // Parse JSON payload
			$language = $data->language ?? null;
			$userId = session('userid');
	
			if (!$userId || !$language) {
					return $this->response->setJSON(['success' => false, 'message' => 'Invalid input']);
			}
	
			$userModel = new \App\Models\User();
			$userModel->update($userId, ['language' => $language]);
	
			// Update session language
			session()->set('language', $language);
			\Config\Services::language()->setLocale($language);
	
			return $this->response->setJSON(['success' => true, 'message' => 'Language updated']);
	}
	

public function updateAllProfile()
		{
			
			//We do another matchwithAll afte profile update.


			
			$this->validation = service('validation');
			$rules=[
				//'username' => 'alpha_numeric|min_length[3]|max_length[20]',	
				
				
				// Add common sense rules for other fields
				'userid' => 'numeric|greater_than[0]', // Positive numeric value
				'sex' => 'in_list[Male,Female,Other]', // Predefined values
				'profession' => 'alpha_space', // Alphabetic characters and spaces
				'name' => 'permit_empty|min_length[2]|max_length[20]', // Non-empty field,
				'surname' => 'permit_empty|min_length[2]|max_length[20]', // Non-empty field
				'city' => 'permit_empty|min_length[2]|max_length[20]', // Non-empty field
				'birthdate' => 'valid_date[d/m/Y]',
   			'birthtime' => 'regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]',
				'profilepicture' => 'max_size[profilepicture,2048]|mime_in[profilepicture,image/jpg,image/jpeg,image/png]',
				'aboutme' => 'min_length[20]|max_length[200]'];
			// Run validation
				// Check if the username field is not empty, then add the is_unique rule
				if (!empty($this->request->getPost('username'))) {
					$rules['username'] .=  'alpha_numeric|min_length[3]|max_length[20]|is_unique_username[users,username,' . $this->getUserCurrentUserName(). ']';
					
				
					
				}
						//hack to solve the problem with datepicker


				if ($this->request->getPost('birthdate')) {
					$birthdate = $this->request->getPost('birthdate');
					$formattedDate = \DateTime::createFromFormat('d/m/Y', $birthdate);
					if (!$formattedDate) {
							$errors['birthdate'] = 'The birthdate field must contain a valid date.';
					}
			}
			$this->validation->setRules($rules);
			$validating=$this->validate($this->validation->getRules());
		

			if ($validating) {



				// Validation passed, proceed with further actions
				$userid = $this->request->getPost('userid');
				$sex = $this->request->getPost('sex');
				$profession = $this->request->getPost('profession');
				//$username = $this->request->getPost('username');
				$name = $this->request->getPost('name');
				$surname = $this->request->getPost('surname');
				$bdate = $this->request->getPost('birthdate');
				$btime = $this->request->getPost('birthtime');
				$unknowntime = $this->request->getPost('unknown_time');
				$aboutme = $this->request->getPost('aboutme');
				$timezone_txt = !empty($this->request->getPost('timezone')) 
                ? $this->request->getPost('timezone') 
                : $this->request->getPost('timezone_txt');
				$city = $this->request->getPost('city');
				$birthcountry = $this->request->getPost('birthcountry');
				$lookingfor= $this->request->getPost('lookingfor');
				$lon= $this->request->getPost('longitude');
				$lat= $this->request->getPost('latitude');




				//for public visibility processing
				$data_visibility=[];

			
				//privacy choices
				$data_visibility['name']=$this->request->getPost('visibilityname');
				$data_visibility['surname']=$this->request->getPost('visibilitysurname');
				$data_visibility['sex']=$this->request->getPost('visibilitysex');	
				$data_visibility['bdate']=$this->request->getPost('visibilitybdate');			
				$data_visibility['city']=$this->request->getPost('visibilitycity');
				$data_visibility['profession']=$this->request->getPost('visibilityprofession');
				$data_visibility['aboutme']=$this->request->getPost('visibilityabout');
				$data_visibility['lookingfor']=$this->request->getPost('visibilitylookingfor');
			

				$json_data=json_encode($data_visibility);

				$this->updateUserF($userid, 'sex', $sex);
				$this->updateUserF($userid, 'profession', $profession);
				//$this->updateUserF($userId, 'username', $username);
				$this->updateUserF($userid, 'name', $name);
				$this->updateUserF($userid, 'surname', $surname);
				//$this->updateUserF($userId, 'profilePicture', $profilePicture);	
				$this->updateUserF($userid, 'birthdate', $bdate);
				$this->updateUserF($userid, 'birthtime', $btime);
				$this->updateUserF($userid, 'unknowntime', $unknowntime);
				$this->updateUserF($userid, 'lookingfor', $lookingfor);
				
				$this->updateUserF($userid, 'aboutme', $aboutme);
				$this->updateUserF($userid, 'timezone_txt', $timezone_txt);
				$this->updateUserF($userid, 'city', $city);
				$this->updateUserF($userid, 'birthcountry', $birthcountry);
				$test1=$this->updateUserF($userid, 'lon', $lon);
				$test=$this->updateUserF($userid, 'lat', $lat);

				$this->uploadProfilePicture();
			
				// Further actions after validation
			$this->user->setAsNew( $this->request->getPost('userid'));
				
			} 
			
			
			
			 else {
    // Validation failed, handle errors
    $errors = $this->validation->getErrors();
    // Store input data in session
		session()->setFlashdata('old_input', $this->request->getPost());
   
    return redirect()->back()->withInput()->with('errors', $errors);
    // Handle errors, like displaying them to the user or logging
}
		
			return redirect()->to('/profile');
		}


	

public function updateUserF($userId, $field, $value)
		{


			$UserBirth_Table_Select_Condition= $field == 'birthdate'|| $field == 'birthtime_txt' || $field == 'lon' || $field == 'lat' || $field == 'birthtime' || $field == 'timezone'|| $field == 'city'||$field == 'birthcountry'|| $field == 'timezone_txt'|| $field == 'unknowntime';

			$UserProfInfo_Table_Select_Condition= $field == 'profession';

			$UserInterests_Table_Select_Condition= $field =='lookingfor';

			if($UserBirth_Table_Select_Condition) 
				{
					$currentData =$this->userBirth->find($userId);
				}

			else if($UserProfInfo_Table_Select_Condition) 
				
				{
					$currentData =$this->userProf->find($userId);
				}

			else if($UserInterests_Table_Select_Condition) 
				
				{
					$currentData =$this->userInterests->find($userId);
				}


			else{$currentData = $this->user->find($userId);}


			if (!$currentData) {
				return 'User does not exist.';
			}
			if ($currentData[$field] == $value) {
				return 'There is no data to update.';
			}
		

			try {

				if($UserBirth_Table_Select_Condition) 
				
				{
					$update=$this->userBirth->updateUserField($userId, $field, $value);
				}
				
				else if($UserProfInfo_Table_Select_Condition) 
				
				{
					$update=	$this->userProf->updateUserField($userId, $field, $value);
				}

				else if($UserInterests_Table_Select_Condition) 
				
				{
					$update=	$this->userInterests->updateUserField($userId, $field, $value);
				}


				else{
					$update= $this->user->updateUserField($userId, $field, $value);
				}	

				return 'Profile updated successfully';
				} 
			
			catch (\Exception $e) {
				// Log the exception message
				log_message('error', $e->getMessage());
				return 'Failed to update profile due to an error.';
				}
		}	

function toDMS($decimalDegrees) {
    $deg = floor($decimalDegrees);
    $min = floor(($decimalDegrees - $deg) * 60);
    $sec = round(($decimalDegrees - $deg - $min / 60) * 3600, 2);
    return "{$deg}° {$min}' {$sec}\"";
}

}