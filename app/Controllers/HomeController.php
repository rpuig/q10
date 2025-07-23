<?php

namespace App\Controllers;
use App\config\Config;

class HomeController extends BaseController
{
    
	public function __construct()
	{
		
	}
	public function index()
    {
		
		$data=$this->data;
		$data['seo_title'] = 'Home';
		$config = config('App');
		$data['siteName']=  $config->siteName;
		$data['session']=$this->session;

	
		  // Check if a language is set in the session, else use default language (en)
			$language = $this->session->get('language') ?? 'en';

			// Set the language in the language service
			$languageService = service('language');
			$languageService->setLocale($language);

			// Load the language helper
			helper('language');

		
		if ($data['loggedIn']) {

			return redirect()->to('/profile');
			// Store the session data in the session
			
		}

		
		return view('pages/home',$data);
	
    }

	

	
}
