<?php 

namespace App\Controllers\Astro;


use App\Controllers\BaseController;
use App\Controllers\MatchController;
use App\Models\User;
use App\Models\UserAstro;

use App\Libraries\astro\cn\Cn;
use App\Libraries\astro\may\My;
use App\Libraries\astro\zod\Zd;
use App\Libraries\astro\hd\Hd;

use App\Models\UserBirth;
class AstroController extends BaseController
{
    protected $userBirth;
    protected $user;
    protected $userAstro;
    protected $cn;
    protected $my;
    protected $zd;

    protected $hd;

    public function __construct()
    {  parent::__construct();
        $this->userBirth = new UserBirth();
        $this->user = new User();
        $this->userAstro = new UserAstro();
		
    }
	public function index()
	{
        $userID = $this->session->get('userid');
		$sessionData =  $this->session->getFlashdata('sessionData');
       // $this->session->set($sessionData);
       

        $row= $this->userBirth->getAllUserData($userID);
        $data=$this->data;
        if($row['birthdate']!='null'&&$row['birthtime']!='null' && $row['sex']!='null')
                    {

                    $this->cn($row);
                    $this->my($row);
                    $this->zd($row);        
                    $this->hd($row);
                
                
                    //Check if user is new 

                   if($this->user->checkIfNew( $userID)) {                  
                   
                    $this->user->setNonfNew($userID);//set user as not new anymore
                     }

                     $this->updateAstroData($userID ,$this->cn,$this->my,$this->zd);
                    
                
                    
                   // $this->userBirth = new UserBirth();
                    $data['cnProfile']=$this->get_cn();
                    $data['myProfile']=$this->get_my();
                    $data['zdProfile']=$this->get_zd(); 
                    $data['hdProfile']=$this->get_hd();

                    $data['seo_title']="Astro profile";
                }
                //Eslse tell user to add correct data
                else{
                   
                    $data['cnProfile']="please add correct data in your Profile ";
                    $data['myProfile']="please add correct data in your Profile";
                    $data['zdProfile']="please add correct data in your Profile";
                    $data['hdProfile']="please add correct data in your Profile";
                    $data['seo_title']="Astro profile";

                }

            return 
		
	
            view('users/AstroProfile', $data) ;
		
	}

    public function updateAstroData($userID,$cn,$my,$zd){

        $this->userAstro->updateAstro( $userID,$cn->get_cn_profile(),$my->get_my_profile(),$zd->get_zd_profile());

        

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
		//$this->hd->printToCsv("hd.csv");
       // $this->hd->appendToCsv("hd.csv");
	}
    public function get_hd()
	{
        return  $this->hd->get_hd_result_display();        
	}
    /* public function get_hd_csv()
	{
         return  $this->hd->printToCsv();        
	} */

}