<?php
include ("cn/cn.php");
include ("may/my.php");
include ("num/num.php");
include ("zod/zod.php");
include ("hd/hd.php");

Class Profile{
	

	private $usr_id;
	private  $name;
	private  $surname;
	private  $bday;
	private  $btime;
	private  $latitude;
	private  $longitude;	
	

	private $rows;
	
	public  $cn_prof;
	public  $my_prof;
	public  $num_prof;
	public  $zod_prof;
	public  $hd_prof;
	private $combined;
	public 	$combined_profile;


	//add static method instead of construct 
	public function __CONSTRUCT($row){
			
		$this->bday=$row['day']."-".$row['month']."-".$row['year'];
		$this->btime=$row['hour'].":".$row['minute'];
		
		$this->name=$row['name'];
		$this->surname=$row['surname'];
		$this->usr_id=$row['ID'];   

		$this->cn_prof=new cn($row);
	
		
		$this->my_prof=new my($row);
		$this->zod_prof=new zod($row);		
		$this->hd_prof=new hd($this->zod_prof->get_zd_profile(),$this->zod_prof->get_zd_profile_ds());
		$this->combined_profile=new stdClass;
		$this->combined=new stdClass;	
		
		$this->combined->id=$row['ID'];  	
		$this->combined->name=$row['name'];
		$this->combined->surname=$row['surname'];

		$this->combined->bday=$row['day']."-".$row['month']."-".$row['year'];
		$this->combined->btime=$row['hour'].":".$row['minute'];

		$this->combined->latitude=$row['latitude'];
		$this->combined->longitude=$row['longitude'];

		$this->combined->planet_pos;
		$this->combined->house_pos;
		$this->combined->rising;
		$this->combined->sun;
		$this->combined->moon;   
        
		$this->combined->eb_hour;
		$this->combined->eb_day;
		$this->combined->eb_month;
		$this->combined->eb_year; 

		$this->combined->eb_hour_eng;
		$this->combined->eb_day_eng;
		$this->combined->eb_month_eng;
		$this->combined->eb_year_eng;

		$this->combined->hs_hour;
		$this->combined->hs_day;
		$this->combined->hs_month;
		$this->combined->hs_year;    
    
		$this->combined->destiny;
		$this->combined->guide;
		$this->combined->occult;
		$this->combined->antipode;
		$this->combined->analogue;
		$this->combined->tribe;

		$this->combined->dst_number;
		$this->combined->lp_number;
		$this->combined->lp_group;
		$this->combined->sl_number; 
		$this->combined->dst_number_full;
		
	} 

	public function display_profile(){
		$this->get_user_info_display();
		$this->cn_prof->get_cn_result_display();
		$this->zod_prof->get_zd_result_display();
		$this->my_prof->get_my_result_display();


	}
	public function get_user_info_display(){
		echo("<table>");
		
		foreach ($this->combined as $key=>$value)
		{
			echo("<tr>");echo("<td>");echo($key);echo("</td>");echo("<td>"); echo($value);echo("</td>");echo("</tr>");		
		}
		
		echo("</table>");
	}
	
	public function export_profile_csv(){
		$p_info=
			["Name"=>$this->name,
			"Surname"=>$this->surname,
			"Id"=>$this->usr_id ];

			$export=[];
			$cn_info=(array)$this->cn_prof->get_cn_profile();
			$my_info=(array)$this->my_prof->get_my_profile();

			$keysToRemove = ['elm_level', 'el_level','HS_Hour_nbr','HS_Day_nbr','HS_Month_nbr','HS_Year_nbr','EB_Hour','EB_Day','EB_Month','EB_Year','EB_Hour_nbr','EB_Day_nbr','EB_Month_nbr','EB_Year_nbr'];
			foreach ($keysToRemove as $key) {
				unset($cn_info[$key]);
			}
			//$my_info=$this->my_prof->get_my_profile();

			$export=array_merge($p_info,$cn_info,/*$my_info*/);


			$newOrder = 
			['Name','Surname','Id','bd','bt',
			'HS_Hour','EB_Hour_eng',
			'HS_Day','EB_Day_eng',
			'HS_Month','EB_Month_eng',
			'HS_Year','EB_Year_eng',
			'Season','Timeliness','element_prof','elm_level_str','yang_level','yin_level']; // Define the new order of keys

			$export = array_merge(array_flip($newOrder), $export);

			$export=array_merge($export,$my_info);


			
		
	

			return $export;
	}

}


