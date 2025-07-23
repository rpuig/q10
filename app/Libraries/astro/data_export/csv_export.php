
<?php
include ('../header.php');
include('../profile.php');
include ('../db/db.php');

//Enter data into dabtabase with form

//Iterate throght each row
$database=new db(HOST,USER,PASSWORD,DATABASE);
$table_name="birth_info";
$conn=$database->makeconnection();
$final_array=[];
$row_nbr=$database->get_table_num_rows($table_name,$conn);

for ($i=1;$i<=$row_nbr;$i++){

	$row=$database->get_row($i,$table_name,$conn);
	$prof=new Profile($row);
	$final_array=array_merge( $final_array, $prof->export_profile_csv());
	   // Append the profile data to the final array
	   foreach ($profileData as $key => $value) {
        $final_array[] = $value;
    }

}


			
			
       

     
      
     
			



// create profile per row
// get data from profile
  
//append the data to 


$filename = getcwd() . '/profile_export.csv';
$fp = fopen($filename, 'w');
if ($fp === false) {
    $error = error_get_last();
    echo "Could not open file '$filename'. Error: " . $error['message'];
} else {
    $list = $final_array;
    $header_array = [];
    $row_array = [];
    $i = 0;

    foreach ($list as $field) {
        array_push($header_array, array_keys($list)[$i]);
        array_push($row_array, $field);
        $i++;
    }

    $data_array = array($header_array, $row_array);

    foreach ($data_array as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp); // Close the file after writing
}

// Rest of your script...
