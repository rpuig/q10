<?php


function search_values3($array,$Year,$Month,$Day){	
	$result = (object) [    'SN' => "s/n",    'HS_Year' => 0,'EB_Year' => 0,'HS_Month' => 0,'EB_Month' => 0,'HS_Day' => 0,'EB_Day' => 0,'Season' => 0,
  ];
	for ($i=0;$i<count($array);$i++){
		if (($array[$i]['Year']==$Year)&&($array[$i]['Month']==$Month)&&($array[$i]['Day']==$Day)){
			
		
		$result->SN=$array[$i]['S/N'];		
		$result->HS_Year=$array[$i]['HS of Year'];
		$result->EB_Year=$array[$i]['EB of Year'];
		$result->HS_Month=$array[$i]['HS of Month'];
		$result->EB_Month=$array[$i]['EB of Month'];
		$result->HS_Day=$array[$i]['HS of Day'];
		$result->EB_Day=$array[$i]['EB of Day'];
		$result->Season=$array[$i]['Season'];
		
		}
		else{
			
		}
	}
	
	
	
	
	return $result;
}



?>