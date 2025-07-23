<?php

if (!defined('OCCULT_SCORE')) {
define('OCCULT_SCORE'	, 2);
}
if (!defined('ANALOGUE_SCORE')) {
define('ANALOGUE_SCORE'	, 4);
}
if (!defined('ANTIPODE_SCORE')) {
define('ANTIPODE_SCORE'	, -4);
}
if (!defined('GUIDE_SCORE')) {
define('GUIDE_SCORE'	, 3);
}
if (!defined('DESTINY_SCORE')) {
define('DESTINY_SCORE'	, 0);
}
if (!defined('HS_SCORE_TABLE')) {
define('HS_SCORE_TABLE'	, "match_scores_hs_hs_scores");
    }
if (!defined('EB_SCORE_TABLE')) {
define('EB_SCORE_TABLE'	, "match_scores_eb_eb_scores");
    }
if (!defined('EB_WEIGHTS_TABLE')) {
define('EB_WEIGHTS_TABLE', "match_scores_eb_eb_weights");
    } 
if (!defined('HS_WEIGHTS_TABLE')) {
define('HS_WEIGHTS_TABLE', "match_scores_hs_hs_weights");
    }
if (!defined('EB_FULL_WEIGHTS_TABLE')) {
        define('EB_FULL_WEIGHTS_TABLE', "match_scores_hs_hs_full_weights");
            } 
if (!defined('HS_FULL_WEIGHTS_TABLE')) {
                define('HS_FULL_WEIGHTS_TABLE', "match_scores_eb_eb_full_weights");
                    }  

/*CN MATCH */
  
  /*To transalte database position into readable names */
   $hs_translation_matrix=array(
    
    "yang wood"=>array("yang wood"=>"aa","yin wood"=>"ab",
        "yang fire"=>"ac","yin fire"=>"ad","yang earth"=>"ae","yin earth"=>"af","yang metal"=>"ag","yin metal"=>"ah","yang water"=>"ai","yin water"=>"aj"),

    "yin wood"=>array("yang wood"=>"ba","yin wood"=>"bb",
        "yang fire"=>"bc","yin fire"=>"bd","yang earth"=>"be","yin earth"=>"bf","yang metal"=>"bg","yin metal"=>"bh","yang water"=>"bi","yin water"=>"bj"),

    "yang fire"=>array("yang wood"=>"ca","yin wood"=>"cb",
        "yang fire"=>"cc","yin fire"=>"cd","yang earth"=>"ce","yin earth"=>"cf","yang metal"=>"cg","yin metal"=>"ch","yang water"=>"ci","yin water"=>"cj"),

    "yin fire"=>array("yang wood"=>"da","yin wood"=>"db",
        "yang fire"=>"dc","yin fire"=>"dd","yang earth"=>"de","yin earth"=>"df","yang metal"=>"dg","yin metal"=>"dh","yang water"=>"di","yin water"=>"dj"),

    "yang earth"=>array("yang wood"=>"ea","yin wood"=>"eb",
        "yang fire"=>"ec","yin fire"=>"ed","yang earth"=>"ee","yin earth"=>"ef","yang metal"=>"eg","yin metal"=>"eh","yang water"=>"ei","yin water"=>"ej"),

    "yin earth"=>array("yang wood"=>"fa","yin wood"=>"fb",
        "yang fire"=>"fc","yin fire"=>"fd","yang earth"=>"fe","yin earth"=>"ff","yang metal"=>"fg","yin metal"=>"fh","yang water"=>"fi","yin water"=>"fj"),

    "yang metal"=>array("yang wood"=>"ga","yin wood"=>"gb",
        "yang fire"=>"gc","yin fire"=>"gd","yang earth"=>"ge","yin earth"=>"gf","yang metal"=>"gg","yin metal"=>"gh","yang water"=>"gi","yin water"=>"gj"),

    "yin metal"=>array("yang wood"=>"ha","yin wood"=>"hb",
        "yang fire"=>"hc","yin fire"=>"hd","yang earth"=>"he","yin earth"=>"hf","yang metal"=>"hg","yin metal"=>"hh","yang water"=>"hi","yin water"=>"hj"),

    "yang water"=>array("yang wood"=>"ia","yin wood"=>"ib",
        "yang fire"=>"ic","yin fire"=>"id","yang earth"=>"ie","yin earth"=>"if","yang metal"=>"ig","yin metal"=>"ih","yang water"=>"ii","yin water"=>"ij"),

    "yin water"=>array("yang wood"=>"ja","yin wood"=>"jb",
        "yang fire"=>"jc","yin fire"=>"jd","yang earth"=>"je","yin earth"=>"jf","yang metal"=>"jg","yin metal"=>"jh","yang water"=>"ji","yin water"=>"jj"));


  /*translate position into names for eb*/
  $eb_translation_matrix=array(

      "rat"=>array(
        "rat"=>"aa","ox"=>"ab",
        "tiger"=>"ac","rabbit"=>"ad","dragon"=>"ae","snake"=>"af","horse"=>"ag","sheep"=>"ah","monkey"=>"ai","rooster"=>"aj","dog"=>"ak","pig"=>"al"),
      
      "ox"=>array(
        "rat"=>"ba","ox"=>"bb",
        "tiger"=>"bc","rabbit"=>"bd","dragon"=>"be","snake"=>"bf","horse"=>"bg","sheep"=>"bh","monkey"=>"bi","rooster"=>"bj","dog"=>"bk","pig"=>"bl"),
      
      "tiger"=>array(
        "rat"=>"ca","ox"=>"cb",
        "tiger"=>"cc","rabbit"=>"cd","dragon"=>"ce","snake"=>"cf","horse"=>"cg","sheep"=>"ch","monkey"=>"ci","rooster"=>"cj","dog"=>"ck","pig"=>"cl"),
      
      "rabbit"=>array(
        "rat"=>"da","ox"=>"db",
        "tiger"=>"dc","rabbit"=>"dd","dragon"=>"de","snake"=>"df","horse"=>"dg","sheep"=>"dh","monkey"=>"di","rooster"=>"dj","dog"=>"dk","pig"=>"dl"),
      
      "dragon"=>array(
        "rat"=>"ea","ox"=>"eb",
        "tiger"=>"ec","rabbit"=>"ed","dragon"=>"ee","snake"=>"ef","horse"=>"eg","sheep"=>"eh","monkey"=>"ei","rooster"=>"ej","dog"=>"ek","pig"=>"el"),
      
      "snake"=>array(
        "rat"=>"fa","ox"=>"fb",
        "tiger"=>"fc","rabbit"=>"fd","dragon"=>"fe","snake"=>"ff","horse"=>"fg","sheep"=>"fh","monkey"=>"fi","rooster"=>"fj","dog"=>"fk","pig"=>"fl"),
      
      "horse"=>array(
        "rat"=>"ga","ox"=>"gb",
        "tiger"=>"gc","rabbit"=>"gd","dragon"=>"ge","snake"=>"gf","horse"=>"gg","sheep"=>"gh","monkey"=>"gi","rooster"=>"gj","dog"=>"gk","pig"=>"gl"),
      
      "sheep"=>array(
        "rat"=>"ha","ox"=>"hb",
        "tiger"=>"hc","rabbit"=>"hd","dragon"=>"he","snake"=>"hf","horse"=>"hg","sheep"=>"hh","monkey"=>"hi","rooster"=>"hj","dog"=>"hk","pig"=>"hl"),
      
      "monkey"=>array(
        "rat"=>"ia","ox"=>"ib",
        "tiger"=>"ic","rabbit"=>"id","dragon"=>"ie","snake"=>"if","horse"=>"ig","sheep"=>"ih","monkey"=>"ii","rooster"=>"ij","dog"=>"ik","pig"=>"il"),
      
      "rooster"=>array(
        "rat"=>"ja","ox"=>"jb",
        "tiger"=>"jc","rabbit"=>"jd","dragon"=>"je","snake"=>"jf","horse"=>"jg","sheep"=>"jh","monkey"=>"ji","rooster"=>"jj","dog"=>"jk","pig"=>"jl"),
      
      "dog"=>array(
        "rat"=>"ka","ox"=>"kb",
        "tiger"=>"kc","rabbit"=>"kd","dragon"=>"ke","snake"=>"kf","horse"=>"kg","sheep"=>"kh","monkey"=>"ki","rooster"=>"kj","dog"=>"kk","pig"=>"kl"),
      
      "pig"=>array(
        "rat"=>"la","ox"=>"lb",
        "tiger"=>"lc","rabbit"=>"ld","dragon"=>"le","snake"=>"lf","horse"=>"lg","sheep"=>"lh","monkey"=>"li","rooster"=>"lj","dog"=>"lk","pig"=>"ll"));    




      $eb_translation_matrix_phases_names=array(

        "yang water"=>array(
            "yang water"=>"aa","yin earth"=>"ab",
            "yang wood"=>"ac","yin wood"=>"ad","yang earth"=>"ae","yin fire"=>"af","yang fire"=>"ag","yin earth"=>"ah","yang metal"=>"ai","yin metal"=>"aj","yang earth"=>"ak","yin water"=>"al"),
        
        "yin earth"=>array(
            "yang water"=>"ba","yin earth"=>"bb",
            "yang wood"=>"bc","yin wood"=>"bd","yang earth"=>"be","yin fire"=>"bf","yang fire"=>"bg","yin earth"=>"bh","yang metal"=>"bi","yin metal"=>"bj","yang earth"=>"bk","yin water"=>"bl"),
        
        "yang wood"=>array(
            "yang water"=>"ca","yin earth"=>"cb",
            "yang wood"=>"cc","yin wood"=>"cd","yang earth"=>"ce","yin fire"=>"cf","yang fire"=>"cg","yin earth"=>"ch","yang metal"=>"ci","yin metal"=>"cj","yang earth"=>"ck","yin water"=>"cl"),
        
        "yin wood"=>array(
            "yang water"=>"da","yin earth"=>"db",
            "yang wood"=>"dc","yin wood"=>"dd","yang earth"=>"de","yin fire"=>"df","yang fire"=>"dg","yin earth"=>"dh","yang metal"=>"di","yin metal"=>"dj","yang earth"=>"dk","yin water"=>"dl"),
        
        "yang earth"=>array(
            "yang water"=>"ea","yin earth"=>"eb",
            "yang wood"=>"ec","yin wood"=>"ed","yang earth"=>"ee","yin fire"=>"ef","yang fire"=>"eg","yin earth"=>"eh","yang metal"=>"ei","yin metal"=>"ej","yang earth"=>"ek","yin water"=>"el"),
        
        "yin fire"=>array(
            "yang water"=>"fa","yin earth"=>"fb",
            "yang wood"=>"fc","yin wood"=>"fd","yang earth"=>"fe","yin fire"=>"ff","yang fire"=>"fg","yin earth"=>"fh","yang metal"=>"fi","yin metal"=>"fj","yang earth"=>"fk","yin water"=>"fl"),
        
        "yang fire"=>array(
            "yang water"=>"ga","yin earth"=>"gb",
            "yang wood"=>"gc","yin wood"=>"gd","yang earth"=>"ge","yin fire"=>"gf","yang fire"=>"gg","yin earth"=>"gh","yang metal"=>"gi","yin metal"=>"gj","yang earth"=>"gk","yin water"=>"gl"),
        
        "yin earth"=>array(
            "yang water"=>"ha","yin earth"=>"hb",
            "yang wood"=>"hc","yin wood"=>"hd","yang earth"=>"he","yin fire"=>"hf","yang fire"=>"hg","yin earth"=>"hh","yang metal"=>"hi","yin metal"=>"hj","yang earth"=>"hk","yin water"=>"hl"),
        
        "yang metal"=>array(
            "yang water"=>"ia","yin earth"=>"ib",
            "yang wood"=>"ic","yin wood"=>"id","yang earth"=>"ie","yin fire"=>"if","yang fire"=>"ig","yin earth"=>"ih","yang metal"=>"ii","yin metal"=>"ij","yang earth"=>"ik","yin water"=>"il"),
        
        "yin metal"=>array(
        "yang water"=>"ja","yin earth"=>"jb",
        "yang wood"=>"jc","yin wood"=>"jd","yang earth"=>"je","yin fire"=>"jf","yang fire"=>"jg","yin earth"=>"jh","yang metal"=>"ji","yin metal"=>"jj","yang earth"=>"jk","yin water"=>"jl"),
        
        "yang earth"=>array(
            "yang water"=>"ka","yin earth"=>"kb",
            "yang wood"=>"kc","yin wood"=>"kd","yang earth"=>"ke","yin fire"=>"kf","yang fire"=>"kg","yin earth"=>"kh","yang metal"=>"ki","yin metal"=>"kj","yang earth"=>"kk","yin water"=>"kl"),
        
        "yin water"=>array(
            "yang water"=>"la","yin earth"=>"lb",
            "yang wood"=>"lc","yin wood"=>"ld","yang earth"=>"le","yin fire"=>"lf","yang fire"=>"lg","yin earth"=>"lh","yang metal"=>"li","yin metal"=>"lj","yang earth"=>"lk","yin water"=>"ll"));    
  



 /* 
      $eb_translation_matrix = array(
        "Rat" => array(
            "Rat" => "aa", "Ox" => "ab",
            "Tiger" => "ac", "Rabbit" => "ad", "Dragon" => "ae", "Snake" => "af", "Horse" => "ag", "Sheep" => "ah", "Monkey" => "ai", "Rooster" => "aj", "Dog" => "ak", "Pig" => "al"
        ),
        
        "Ox" => array(
            "Rat" => "ba", "Ox" => "bb",
            "Tiger" => "bc", "Rabbit" => "bd", "Dragon" => "be", "Snake" => "bf", "Horse" => "bg", "Sheep" => "bh", "Monkey" => "bi", "Rooster" => "bj", "Dog" => "bk", "Pig" => "bl"
        ),
        
        "Tiger" => array(
            "Rat" => "ca", "Ox" => "cb",
            "Tiger" => "cc", "Rabbit" => "cd", "Dragon" => "ce", "Snake" => "cf", "Horse" => "cg", "Sheep" => "ch", "Monkey" => "ci", "Rooster" => "cj", "Dog" => "ck", "Pig" => "cl"
        ),
        
        "Rabbit" => array(
            "Rat" => "da", "Ox" => "db",
            "Tiger" => "dc", "Rabbit" => "dd", "Dragon" => "de", "Snake" => "df", "Horse" => "dg", "Sheep" => "dh", "Monkey" => "di", "Rooster" => "dj", "Dog" => "dk", "Pig" => "dl"
        ),
        
        "Dragon" => array(
            "Rat" => "ea", "Ox" => "eb",
            "Tiger" => "ec", "Rabbit" => "ed", "Dragon" => "ee", "Snake" => "ef", "Horse" => "eg", "Sheep" => "eh", "Monkey" => "ei", "Rooster" => "ej", "Dog" => "ek", "Pig" => "el"
        ),
        
        "Snake" => array(
            "Rat" => "fa", "Ox" => "fb",
            "Tiger" => "fc", "Rabbit" => "fd", "Dragon" => "fe", "Snake" => "ff", "Horse" => "fg", "Sheep" => "fh", "Monkey" => "fi", "Rooster" => "fj", "Dog" => "fk", "Pig" => "fl"
        ),
        
        "Horse" => array(
            "Rat" => "ga", "Ox" => "gb",
            "Tiger" => "gc", "Rabbit" => "gd", "Dragon" => "ge", "Snake" => "gf", "Horse" => "gg", "Sheep" => "gh", "Monkey" => "gi", "Rooster" => "gj", "Dog" => "gk", "Pig" => "gl"
        ),
        
        "Sheep" => array(
            "Rat" => "ha", "Ox" => "hb",
            "Tiger" => "hc", "Rabbit" => "hd", "Dragon" => "he", "Snake" => "hf", "Horse" => "hg", "Sheep" => "hh", "Monkey" => "hi", "Rooster" => "hj", "Dog" => "hk", "Pig" => "hl"
        ),
        
        "Monkey" => array(
            "Rat" => "ia", "Ox" => "ib",
            "Tiger" => "ic", "Rabbit" => "id", "Dragon" => "ie", "Snake" => "if", "Horse" => "ig", "Sheep" => "ih", "Monkey" => "ii", "Rooster" => "ij", "Dog" => "ik", "Pig" => "il"
        ),
        
        "Rooster" => array(
            "Rat" => "ja", "Ox" => "jb",
            "Tiger" => "jc", "Rabbit" => "jd", "Dragon" => "je", "Snake" => "jf", "Horse" => "jg", "Sheep" => "jh", "Monkey" => "ji", "Rooster" => "jj", "Dog" => "jk", "Pig" => "jl"
        ),
        
        "Dog" => array(
            "Rat" => "ka", "Ox" => "kb",
            "Tiger" => "kc", "Rabbit" => "kd", "Dragon" => "ke", "Snake" => "kf", "Horse" => "kg", "Sheep" => "kh", "Monkey" => "ki", "Rooster" => "kj", "Dog" => "kk", "Pig" => "kl"
        ),
        
        "Pig" => array(
            "Rat" => "la", "Ox" => "lb",
            "Tiger" => "lc", "Rabbit" => "ld", "Dragon" => "le", "Snake" => "lf", "Horse" => "lg", "Sheep" => "lh", "Monkey" => "li", "Rooster" => "lj", "Dog" => "lk", "Pig" => "ll"
        )
    ); */
    
      
      // Serialize the array
      $S_hs_translation_matrix = serialize($hs_translation_matrix);
      $S_eb_translation_matrix = serialize($eb_translation_matrix);

      // Define the constant with the serialized value
      define('HS_TRANSLATION_MATRIX_ALPHABETICAL', $S_hs_translation_matrix);

      define('EB_TRANSLATION_MATRIX', $S_eb_translation_matrix );

