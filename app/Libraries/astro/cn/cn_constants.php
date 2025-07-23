<?php
//Constants for display

/*HEAVENLY STEMS*/
/*
$heavenly_stems_chinese_names=array(1=>"jia",2=>"Yi",
3=>"Bing",4=>"Ding",5=>"Wu",6=>"Ji",7=>"Geng",8=>"Xin",9=>"Ren",10=>"Gui");*/

$ten_heavenly_stems_english_names=array(1=>"yang wood",2=>"yin wood",
3=>"yang fire",4=>"yin fire",5=>"yang earth",6=>"yin earth",7=>"yang metal",8=>"yin metal",9=>"yang water",10=>"yin water");


/*EARTHLY BRANCHES*/

$twelve_earthly_branches_eng_names=array(1=>"rat",2=>"ox",3=>"tiger",4=>"rabbit",5=>"dragon",6=>"snake",7=>"horse",8=>"sheep",9=>"monkey",10=>"rooster",11=>"dog",12=>"pig");
/*$twelve_earthly_branches_eng_names = array(
    1 => "Rat",
    2 => "Ox",
    3 => "Tiger",
    4 => "Rabbit",
    5 => "Dragon",
    6 => "Snake",
    7 => "Horse",
    8 => "Sheep",
    9 => "Monkey",
    10 => "Rooster",
    11 => "Dog",
    12 => "Pig"
);*/
$twelve_earthly_branches_phase_names=array(1=>"yang water",2=>"yin earth",3=>"yang wood",4=>"yin wood",5=>"yang earth",6=>"yin fire",7=>"yang fire",8=>"yin earth",9=>"yang metal",10=>"yin metal",11=>"yang earth",12=>"yin water");
/*
$twelve_earthly_branches_chinese_names=array(1=>"Zǐ",2=>"Chǒu",3=>"Yín",4=>"Mǎo",5=>"Chén",6=>"Sì",7=>"Wǔ",8=>"Wèi",9=>"Shēn",10=>"Yǒu",
11=>"Xū",12=>"Hài");*/

$twelve_default_earthly_branches_order_months=array(1=>"tiger",2=>"rabbit",
3=>"dragon",4=>"snake",5=>"horse",6=>"sheep",7=>"rooster",8=>"monkey",9=>"dog",10=>"pig",11=>"rat",12=>"ox");


/*TIMELINESS */

$twelve_season_english=array(1=>"Early Spring",2=>"Mid Spring",
3=>"Late Spring",4=>"Early Summer",5=>"Mid Summer",6=>"Late Summer",7=>"Early Autumn",8=>"Mid Autumn",9=>"Late Autumn",10=>"Early Winter",11=>"Mid Winter",12=>"Late Winter");

$twelve_season_months=array(1=>"February",2=>"March",
3=>"April",4=>"May",5=>"June",6=>"July",7=>"August",8=>"September",9=>"October",10=>"November",11=>"December",12=>"January");

$twelve_season_phases=array(1=>"wood",2=>"wood",
3=>"earth",4=>"Fire",5=>"Fire",6=>"earth",7=>"metal",8=>"metal",9=>"earth",10=>"water",11=>"water",12=>"earth");



if (!defined('ten_heavenly_stems_english_names')) define('ten_heavenly_stems_english_names', array(

	1=>"yang wood",
	2=>"yin wood",
	3=>"yang fire",
	4=>"yin fire",
	5=>"yang earth",
	6=>"yin earth",
	7=>"yang metal",
	8=>"yin metal",
	9=>"yang water",
	10=>"yin water"));	

if (!defined('hidden_stems_1')) define('hidden_stems_1', array(

	1=>["yin water"],
	2=>["yin metal","yin earth","yin water"],
	3=>["yang earth","yang wood","yang fire"],
	4=>["yin wood"],
	5=>["yin water","yang earth","yin wood"],
	6=>["yang metal","yang fire","yang earth"],
	7=>["yin fire","yin earth"],
	8=>["yin fire","yin earth","yin wood"],
	9=>["yang earth","yang metal","yang water"],
	10=>["yin metal"],
	11=>["yin fire","yang earth","yin metal"],
	12=>["yang water","yang wood"]));	

if (!defined('hidden_stems')) define('hidden_stems', array(

	"Rat"=>["yin water"],
	"Ox"=>["yin metal","yin earth","yin water"],
	"Tiger"=>["yang earth","yang wood","yang fire"],
	"Rabbit"=>["yin wood"],
	"Dragon"=>["yin water","yang earth","yin wood"],
	"Snake"=>["yang metal","yang fire","yang earth"],
	"Horse"=>["yin fire","yin earth"],
	"Sheep"=>["yin fire","yin earth","yin wood"],
	"Monkey"=>["yang earth","yang metal","yang water"],
	"Rooster"=>["yin metal"],
	"Dog"=>["yin fire","yang earth","yin metal"],
	"Pig"=>["yang water","yang wood"]));	    

if (!defined('hidden_stems_nbr')) define('hidden_stems_nbr', array(

	1=>[10],
	2=>[8,6,10],
	3=>[5,1,3],
	4=>[2],
	5=>[10,5,2],
	6=>[7,3,5],
	7=>[4,6],
	8=>[4,6,2],
	9=>[5,7,9],
	10=>[8],
	11=>[4,5,8],
	12=>[9,1]));	

 if (!defined('twelve_earthly_branches_eng_names')) define('twelve_earthly_branches_eng_names', array(

	1=>"rat",
	2=>"ox",
	3=>"tiger",
	4=>"rabbit",
	5=>"dragon",
	6=>"snake",
	7=>"horse",
	8=>"sheep",
	9=>"monkey",
	10=>"rooster",
	11=>"dog",
	12=>"pig"));	
		
if (!defined('twelve_earthly_branches_phase_names')) define('twelve_earthly_branches_phase_names', array(

	1=>"yang water",        
	2=>"yin earth",        
	3=>"yang wood",
	4=>"yin wood",        
	5=>"yang earth",        
	6=>"yin fire",
	7=>"yang fire",        
	8=>"yin earth",        
	9=>"yang metal",	
	10=>"yin metal",        
	11=>"yang earth",        
	12=>"yin water"));	


if (!defined('twelve_default_earthly_branches_order_months')) define('twelve_default_earthly_branches_order_months',array(

	1=>"tiger",
	2=>"rabbit",
	3=>"dragon",
	4=>"snake",
	5=>"horse",
	6=>"sheep",
	7=>"monkey",
	8=>"rooster",
	9=>"dog",
	10=>"pig",
	11=>"rat",
	12=>"ox"));	


if (!defined('twelve_season_english')) define('twelve_season_english',array(

	1=>"Early Spring",
	2=>"Mid Spring",
	3=>"Late Spring",
	4=>"Early Summer",
	5=>"Mid Summer",
	6=>"Late Summer",
	7=>"Early Autumn",
	8=>"Mid Autumn",
	9=>"Late Autumn",
	10=>"Early Winter",
	11=>"Mid Winter",
	12=>"Late Winter"));	

if (!defined('twelve_season_english')) define('twelve_season_english',array(

	1=>"February",
	2=>"March",
	3=>"April",
	4=>"May",
	5=>"June",
	6=>"July",
	7=>"August",
	8=>"September",
	9=>"October",
	10=>"November",
	11=>"December",
	12=>"January"));	
	

if (!defined('twelve_season_phases')) define('twelve_season_phases',array(
	
	1=>"wood",
	2=>"wood",
	3=>"earth",
	4=>"Fire",
	5=>"Fire",
	6=>"earth",
	7=>"metal",
	8=>"metal",
	9=>"earth",
	10=>"water",
	11=>"water",
	12=>"earth"));

