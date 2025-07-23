<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.



$routes->group(
    '',
    ['filter' => 'auth'],
    static function ($routes) {
   
        $routes->get('users/reset-password', 'users/reset_password');        
        $routes->get('logout', 'UsersController::logout');
        $routes->post('users', 'UsersController::index');
        $routes->get('users', 'UsersController::index');
        $routes->get('profile', 'ProfileController::index');

        $routes->get('users/profile', 'ProfileController::index');
       // $routes->post('users/profile', 'ProfileController::index');


        $routes->get('AstroProfile', 'Astro\AstroController::index');
        $routes->post('AstroProfile', 'Astro\AstroController::index');

        $routes->get('matches', 'Astro\MatchController::index');
        $routes->post('matches', 'Astro\MatchController::index/$1');

        $routes->get('settings', 'ProfileController::UserSettings');
        $routes->post('UpdateUserSettings', 'ProfileController::UpdateUserSettings');

        $routes->get('delete4ever', 'UsersController::Hard_DeleteAccount');
        $routes->get('deleteSoft', 'UsersController::Soft_DeleteAccount');


    
        $routes->post('messages/send', 'MessagesController::sendMessage');

        $routes->post('messages/conversation/(:num)', 'MessagesController::conversation/$1');
        
        //ROUTE CALLED BY MESSAGES.JS loadMessages:

     
      
        $routes->post('updateAllProfile', 'ProfileController::updateAllProfile');


        

        $routes->get('conversations', 'MessagesController::conversations');

        $routes->get('messages/conversations-data', 'MessagesController::conversationsData');

        $routes->get('messages/conversation/(:num)', 'MessagesController::conversation/$1');
        $routes->get('messages/conversation/(:num)/(:num)', 'MessagesController::getConversation/$1/$2');
        
            }   
        );


        $routes->post('updateLanguage', 'ProfileController::updateLanguage');


        $routes->get('goback', 'UtilityController::go_back');
     
       
        $routes->post('validateLogin', 'UsersController::validateLogin');      
        $routes->post('updateProfilePic', 'ProfileController::uploadProfilePicture/$1');  
        $routes->post('updateBirthInfoProfile', 'ProfileController::updateBirthInfoProfile/$1');  
        $routes->get('updateBirthInfoProfile/', 'ProfileController::updateBirthInfoProfile');        
        
        
        $routes->get('/', 'HomeController::index');
        $routes->get('home', 'HomeController::index');      
        $routes->get('userProfile', 'HomeController::index');
        $routes->get('publicProfile', 'ProfileController::publicProfile');
        $routes->post('publicProfile', 'ProfileController::publicProfile');
        $routes->get('publicProfile/(:segment)', 'ProfileController::publicProfile/$1');
        $routes->get('users/login', 'UsersController::login');
        $routes->post('users/login', 'UsersController::login'); 

        $routes->get('login', 'UsersController::login');
        $routes->post('users/register', 'UsersController::registerUser');              
        $routes->get('users/register', 'UsersController::register');    
        
        $routes->get('verify/(:alphanum)', 'UsersController::verify/$1');



        
    
   
        $routes->group('bets',
          
            static function ($routes) {
           
                $routes->get('TennisResults', 'bets\Tennis\TennisCsvController::index');  
        
               
                    }
                );        



// $routes('(:segment)', 'pages/view/)$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
