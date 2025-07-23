<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\ProfileController;

use App\Models\User;
use App\Models\userBirth;
use App\Models\UserMatches;


use CodeIgniter\API\ResponseTrait;

use CodeIgniter\I18n\Time;
//use GeoIp2\Database\Reader;

class UsersController extends BaseController
{
	use ResponseTrait;

	protected User $user;
	protected userMatches $userMatches;
	protected UserBirth $userBirth;
	protected $validation;
	public $staticPages;
	


	// Looking to send emails in production? Check out our Email API/SMTP product!
private $email_config1= Array(
  'protocol' => 'smtp',
	'SMTPHost' => 'mail.ramonpuig.me',
  'SMTPPort' => 465,
  'SMTPUser' => 'coding@ramonpuig.me',
  'SMTPPass' => 'doremifa7',
	'FromEmail'=>'coding@ramonpuig.me',
  'SMTPCrypto' => 'ssl',
  'crlf' => "\r\n",
  'newline' => "\r\n"
);


private $email_config2 = Array(
  'protocol' => 'smtp',
  'SMTPHost' => 'sandbox.smtp.mailtrap.io',
  'SMTPPort' => 2525,
  'SMTPUser' => '62d5a8af46fd9f',
  'SMTPPass' => '398d1a9cc41d5c',
  'smtp_crypto' => 'tls',
  'crlf' => "\r\n",
	'FromEmail'=>"coding@ramonpuig.me",
  'newline' => "\r\n"
);

/* private $email_config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'sandbox.smtp.mailtrap.io',
  'smtp_port' => 2525,
  'smtp_user' => '62d5a8af46fd9f',
  'smtp_pass' => '398d1a9cc41d5c',
  'smtp_crypto' => 'tls',
  'crlf' => "\r\n",
  'newline' => "\r\n"
); */
	/**
	 * constructor
	 */
	public function __construct()
	{	
		parent::__construct();
	
		helper(['form', 'url','menu','time']);
		
		$this->user=new User();


//exit;
		//$this->usermatches=new UserMatches();
		//$this->userBirth=new UserBirth();
		
	}



	
	
	public function List(){


		return $this->user->getAllMessages();

	}
	
	
	
	
	//manages register form view 
	 public function register($validators = [])
	{
    

		$data=$this->data;

    if (!$this->session->has('loggedIn') || $this->session->get('loggedIn') === null) {		// 'loggedIn' is not set or is null

		//$this->validation = \Config\Services::validation();
				$this->validation = service('validation');


				if ($this->request->getMethod() === 'post') {

					$this->validation->setRules([
					'username' => 'required|alpha_numeric|min_length[3]|max_length[20]|is_unique[Users.username]',
					'email' => 'required|valid_email|is_unique[Users.email]',
					'password' => 'required|min_length[1]',
					'password2' => 'required|min_length[1]|matches[password]',
					]);
					$data['title'] = 'Sign Up';
					$data['staticPages'] = $this->staticPages;
					$data['validation'] = $this->validation;
					$data['seo_title'] = 'Register';
					$data['seo_desc'] = 'Register';
					$data['tags'] = ['Register'];
					$data['Registered_Message']='Thank you for registering, please login.';
						//If the validation does not passs
					if (!$this->validate($this->validation->getRules())) {
						$data['validation'] = $this->validation;
						return view('users/register', $data);
					}
					

					else{
							// register user to db
							return view('users/register',$data);
						}

					}

				else { 
						
					$data['title'] = 'Sign Up';
					$data['staticPages'] = $this->staticPages;
					$data['errors'] = $this->validation->getErrors();
					$data['seo_title'] = 'Register';
					$data['seo_desc'] = 'Register';
					$data['tags'] = ['Register'];
					$data['Registered_Message']='Thank you for registering, please login.';
					return   view('users/register', $data);	
						}
      	
    	
		}
   	else {
		$data['title'] = 'Home';
		$data['seo_title'] = 'Home';
		$data['seo_desc'] = 'Home';

		$data+=$this->data;
       
		return redirect()->back();
    }
}

	
	 /**
	 * register into the db */

	 public function registerUser()
	 {
			 $data = [];
	 
			 // Ensure session is started if not already
			 if (session_status() == PHP_SESSION_NONE) {
					 session_start();
			 }
	 
			 // Check if the user is already logged in
			 if ($this->session->has('loggedIn') && $this->session->get('loggedIn') !== null) {
					 $data['title'] = 'Home';
					 $data['seo_title'] = 'Home';
					 $data['seo_desc'] = 'Home';
					 $data += $this->data;
					 $data['loggedIn'] = $this->session->get('loggedIn');
					 return view('profile', $data);
			 }
	 
			 // Check if the request is a POST request
			 if (!$this->request->is('post')) {
					 $data['title'] = 'Sign Up';
					 $data['seo_title'] = 'Register';
					 $data['seo_desc'] = 'Register';
					 $data['tags'] = ['Register'];
					 $data['loggedIn'] = $this->session->get('loggedIn');
					 return view('users/register', $data);
			 }
	 
			 // Validation rules
			 $rules = [
					 'username' => 'required|alpha_numeric|min_length[3]|max_length[20]|is_unique[users.username]',
					 'email' => 'required|valid_email|is_unique[users.email]',
					 'password' => 'required|min_length[5]',
					 'password2' => 'required|min_length[5]|matches[password]'
			 ];
	 
			 // Validate the input data
			 if (!$this->validate($rules)) {
					 $data['validation'] = $this->validator;
					 $data['title'] = 'Sign Up';
					 $data['seo_title'] = 'Register';
					 $data['seo_desc'] = 'Register';
					 $data['tags'] = ['Register'];
					 $data['loggedIn'] = $this->session->get('loggedIn');
					 $data['includeTemplate']=False;
					 return view('users/register', $data);
			 }
			 db_connect()->query('SET search_path TO xgroups');


	 		$verificationCode= $this->generateVerificationCode();
			$token = bin2hex(random_bytes(16));

			 // Gather user data
			 $userData = [
					 'username' => $this->request->getPost('username'),
					 'email' => $this->request->getPost('email'),
					 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
					'data_visibility'=>'{}',
					'interests'=>'{}',
					'verificationn_code'=>$verificationCode,
					'verification_token' => $token,
			 ];
			 
			 // Insert the user data into the database
			 $userModel = $this->user;
			 $insertedId = $userModel->insert($userData);
			 $sendEmail=	$this->sendVerificationEmail($userData['email'], $token);

   
		if(	$sendEmail && $insertedId!=false) {
					 session()->setFlashdata('success', 'Success! Registration completed.');
					
					
					 return redirect()->to(site_url('login'));


			 } else {
					 log_message('error', 'Failed to create user');
					 $data['validation'] = $this->validator;
					 $data['title'] = 'Sign Up';
					 $data['seo_title'] = 'Register';
					 $data['seo_desc'] = 'Register';	
					 $data['tags'] = ['Register'];
					 $data['includeTemplate']=False;
					 $data['loggedIn'] = $this->session->get('loggedIn');
					 return view('users/register', $data);
			 }
	 }
	 



private function generateVerificationCode($length = 32) {
    return bin2hex(random_bytes($length / 2));
}
private function sendVerificationEmail($email, $token){

	$emailService = \Config\Services::email();

	$emailService->initialize($this->email_config2); // Custom configuration

	 $emailService->setFrom($this->email_config2['FromEmail'], 'Your Application');
	 
	 $emailService->setSubject('Email Test');
	 $emailService->setMessage('Testing the email class.');
		
		$emailService->setTo($email);
		$emailService->setSubject('Email Verification');
		$emailService->setMessage("
				Click the link below to verify your email:
				<a href='" . base_url("verify/$token") . "'>Verify Email</a>
		");

		if (!$emailService->send()) {
				log_message('error', 'Failed to send verification email: ' . $emailService->printDebugger(['headers']));
				return false;
		}
		else

		return true;
}

	
	//Delete definitely account request
	public function Hard_DeleteAccount()
	{
		
		$this->userMatches=new userMatches();
		$this->user=new User();
		$this->userMatches->deleteAllMatches($this->session->get('userid'));
		$this->user->where('userid', $this->session->get('userid'))->delete();
		

		
		//if permanent deletion

		return redirect()->to(site_url('/logout'));
	}



//mark for deletion by user

	public function Soft_DeleteAccount()
	{
		
		//if softdelete

		$this->user->softDelete($this->session->userid);

		//if permanent deletion

		return redirect()->to(site_url('/home'));
	}


	/* LOGIN VIEW  view	
	 */


	/**
	 * LOGIN VALIDATE validate 
	 */
	



public function validateLogin()
{
    // Initialize dependencies
    $this->user = new User();
    $this->session = session();
    
    // Enforce POST method
    $this->enforcePost();

    // Get input values
    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');
    $returnUrl = $this->request->getVar('return_url');

    // Initialize validation service
    $validation = \Config\Services::validation();

    // Set validation rules
    $rules = [
        'username' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Username is required.'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Password is required.',
                'min_length' => 'Password must be at least 4 characters long.'
            ]
        ]
    ];

    // Set the validation rules
    $validation->setRules($rules);

    // Run validation
    if (!$validation->withRequest($this->request)->run()) {
        // If validation fails, return to login with errors
        return $this->login([
            'validation' => $validation
        ]);
    }

    // Retrieve user by username
    $user = $this->user->getUserByUsername($username);

    // Check if user exists
    if (!$user) {
        session()->setFlashdata('error', 'Failed! Incorrect username.');
        error_log('Login attempt with non-existent username: ' . $username);
        return redirect()->to('/login');
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        session()->setFlashdata('error', 'Failed! Incorrect password.');
        error_log('Failed login attempt for username: ' . $username);
        return redirect()->to('/login');
    }

    // Check user account status
    if ($user['active'] === "false") {
        session()->setFlashdata('verification_link', 'Please verify the link sent to your email first in order to login.');
        return redirect()->to('/login');
    }

    // Prepare session data
    $sessionData = [
        'userid' => $user['userid'],
        'username' => $user['username'],
        'loggedIn' => true,
				'language'=> $user['language']
    ];

    // Set session data
    $this->session->set($sessionData);
    session()->setFlashdata('success', 'Login successful.');
		\Config\Services::language()->setLocale($user['language']);
    // Redirect back
    return $returnUrl ? redirect()->to($returnUrl) : redirect()->to('goback');
}
	public function login2($validators = [])
	{

		$data =$this->data;
		$data['session'] = $this->session;
		$data['validators'] = $validators;
		$data['seo_title'] = 'Login';
		$data['seo_desc'] = 'Login';
		$data['tags'] = ['Login'];
	
		// Check if the session exists and the user is logged in
		if ($this->session && $this->session->get('loggedIn')) {


			
		//$this->session->set(['loggedIn => 1']);

			// Call the index method of ProfileController
			return redirect()->back();
			
		}


		$data+=$this->data;
		
		return view('users/login', $data);
	
		
		
	}


	public function login($data = [])
{
    // Start with default data
    $viewData = $this->data;
    
    // Merge passed data, giving priority to passed data
    $viewData = array_merge($viewData, $data);
    
    // Set session and validation data
    $viewData['session'] = $this->session;
    $viewData['validation'] = $data['validation'] ?? null;
    
    // Set SEO metadata
    $viewData['seo_title'] = 'Login';
    $viewData['seo_desc'] = 'Login';
    $viewData['tags'] = ['Login'];

    // Check if the user is already logged in
    if ($this->session && $this->session->get('loggedIn')) {
        return redirect()->to('goback');
    }

    // Render the login view with all data
    return view('users/login', $viewData);
}

	/**
	 * User logout
	 
	 */
	public function logout()
	{
		session()->destroy();
		return redirect()->to('home');
	}

	private function enforcePost()
	{
		if (strtolower($_SERVER['REQUEST_METHOD']) !== 'post') {
			return $this->response->setStatusCode(405)->setBody('Method Not Allowed');
		}
	}



		///Use of geoip paid database to detect user timezone via user IP .Not used until in production and income is sufficient.
		private function detectUserTimeZone(){

			$databaseFile = APPPATH . 'ThirdParty/GeoLite2/GeoLite2-City.mmdb'; // Adjust the path as per your project structure
			
			// Initialize the GeoLite2 reader
			$reader = new Reader($databaseFile);
			
			// Get visitor's IP address
			$visitorIP = $_SERVER['REMOTE_ADDR'];
			
			try {
				// Query the database for geolocation data
				$record = $reader->city($visitorIP);
				
				// Get timezone from geolocation data
				$timezone = $record->location->timeZone;
				
				// Now $timezone contains the visitor's timezone
				echo $timezone;
			} catch (\Exception $e) {
				// Handle exceptions, if any
				echo 'Error: ' . $e->getMessage();
			}
		}


		public function verify($token)
		{	
			$userModel = new \App\Models\User();

			// Find user by token
			$user = $userModel->where('verification_token', $token)->first();

			if (!$user) {
					return redirect()->to('/invalid-token')->with('error', 'Invalid verification token.');
			}

			// Update user as verified
			$userModel->update($user['userid'], [
					'is_active' => true,
					'verification_token' => null, // Invalidate the token
			]);

			return redirect()->to('/login')->with('success', 'Your email has been verified. You can now log in.');

		}

}
