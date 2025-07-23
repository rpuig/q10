<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\App;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
   
    protected $includeTemplate = true; // Default value. To controll sidebar apparition depending on view
    protected $data=[];
    protected $language;
    protected $session;
    protected $sessionData;

    public $baseURL;
    public $local_server_domain;
    

    /**
     * Constructor.
     */

  
     protected $helpers = ['utils', 'date', 'menu','menu_helper','html','url'];

     public function __construct()
     {
        
 
         // Load helpers
         helper($this->helpers);
        
     }


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        db_connect()->query('SET search_path TO xgroups');

        $this->session = \Config\Services::session();
        //$this->language = \Config\Services::language();
        $language = session('language') ?? 'en';
        \Config\Services::language()->setLocale($language);

        $config = new App();
        $this->baseURL = $config->baseURL;
        $this->local_server_domain = $config->local_server_domain;

       // $this->language->setLocale($this->session->lang); 
        // Preload any models, libraries, etc, here.    

       // Determine whether to include the template or not
            $excludedUrls = ['home','/','',NULL, 'about', 'login','register','users','/users/register','users/registerUser','registerUser','blog', 'contact'];

            // Get the request URI segment 1
            $requestUri = $this->request->getUri()->getSegments();
            $this->includeTemplate = false;
            foreach ($requestUri as $urisegment){


            // Check if the request URI is null or an empty string, or if it is found in the excluded URLs
            if ($urisegment === null ||   $requestUri== NULL || $urisegment === '' || in_array($urisegment, $excludedUrls)) {
                $this->includeTemplate = false;
            } else {
                $this->includeTemplate = true;
            }
             }          



             
     $this->data =['loggedIn' =>   $this->session->get('loggedIn'),
			'userid'=>   $this->session->get('userid'),	
			'siteName' => config('siteName'),
		];

      //      $this->session->set($this->data['loggedIn']);
        $this->data['includeTemplate'] = $this->includeTemplate;
    }

    public function go_back()
    {
        // Handle any logic if needed
        
        // Redirect back to the previous page
        return redirect()->back();
    }
}
