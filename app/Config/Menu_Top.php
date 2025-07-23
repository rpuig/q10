<?php 

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\App;
class Menu_Top extends BaseConfig
{
    
    
    public $items = [
        // Common items
        ['title' => 'Home', 'link' => '/'],
      //  ['title' => 'Blog', 'link' => '/blog'],
        // ...

        // Conditional items
        ['title' => 'Login', 'link' => '/login', 'condition' => 'logged_out'],
        ['title' => 'Register', 'link' => '/users/register', 'condition' => 'logged_out'],

        ['title' => 'Logout', 'link' => '/logout', 'condition' => 'logged_in'],
        ['title' => 'Profile', 'link' => '/profile', 'condition' => 'logged_in'],

        ['title' => 'publicProfile', 'link' => '/publicProfile', 'condition' => 'logged_in', 'condition2'=>'publicProfile' ],
        

        ['title' => 'AstroProfile', 'link' => '/AstroProfile', 'condition' => 'logged_in'  ] ,
        ['title' => 'Matches', 'link' => '/matches', 'condition' => 'logged_in'],
        ['title' => 'Conversations', 'link' => '/conversations', 'condition' => 'logged_in'],
        
        ['title' => 'Settings', 'link' => '/settings', 'condition' => 'logged_in'],
    ];
}
