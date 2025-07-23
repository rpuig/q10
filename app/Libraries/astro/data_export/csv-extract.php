<?php

/*Extracts the fields of a csv file*/

function get_csv($file_path){
   // Read the contents of the file
   $csv = file_get_contents($file_path, FILE_USE_INCLUDE_PATH);
   $lines = explode("\n", $csv);

   // Remove the first element from the array (header row)
   $head = str_getcsv(array_shift($lines));

   // Initialize an array to hold the data
   $data = array();

   // Iterate over each line in the CSV
   foreach ($lines as $i => $line) {
       // Skip empty lines
       if (empty($line)) {
           continue;
       }

       // Parse the line into an array
       $columns = str_getcsv($line);

       // Check if the number of columns matches the header
       if (count($head) != count($columns)) {
           // Handle the error: log or report the line number
           echo "Error: Row $i has an incorrect number of columns. Skipping line.\n";
           continue; // Skip this line
       }

       // Try to combine the header with the current row data
       try {
           $data[] = array_combine($head, $columns);
       } catch (Throwable $e) {
           // Handle any exception that might occur with array_combine
           echo "Error on line $i: " . $e->getMessage() . "\n";
           continue; // Skip the line with error
       }
   }

   // Return the cleaned data
   return $data;
}



function get_csv3b($file_path){
	
	$row = 1;
                    
                 //read th
   
                
	if (($temp = fopen($file_path, "r")) !== FALSE) {
		
                                 //replace_spec_characters($file_path);
                                 
                            
                                  
                                   
		while (($data = fgetcsv($temp, 1000, ";")) !== FALSE) {
			if($row == 1){ $row++; continue; } /*to jump first line of csv which should only 
			contain the headers from the columns of the original spreadsheet file*/
			  
			//setlocale(LC_ALL, 'es_ES'); /* This is to try to get the special characters from different languages */
			
			$number = count($data);			//echo "<p>". $number." of fields on  row  $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $number; $c++) {
				//echo $data[$c] . "<br />";
				if ($data[$c]==null){$c++;
				continue;}
				
				
				$result[$row][$c]=$data[$c];  /*Here we create and initialise the result returned by function with header and value */
			}
		}
		fclose($temp);
	}
	else {
		
		  echo ( "error reading file") ;   
		
	}
	return $result;
}
function get_csv4($file_path){
	
	$row = 1;
                    
                 //read th
   
                
	if (($temp = fopen($file_path, "r")) !== FALSE) {
		
                                 //replace_spec_characters($file_path);
                                 
                            
                                  
                                   
		while (($data = fgetcsv($temp, 1000, ",")) !== FALSE) {
			if($row == 1){ $row++; continue; } /*to jump first line of csv which should only 
			contain the headers from the columns of the original spreadsheet file*/
			  
			//setlocale(LC_ALL, 'es_ES'); /* This is to try to get the special characters from different languages */
			
			$number = count($data);			//echo "<p>". $number." of fields on  row  $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $number; $c++) {
				//echo $data[$c] . "<br />";
				if ($data[$c]==null){$c++;
				continue;}
				
				
				$result[$row][$c]=$data[$c];  /*Here we create and initialise the result returned by function with header and value */
			}
		}
		fclose($temp);
	}
	else {
		
		  echo ( "error reading file") ;   
		
	}
	return $result;
}
function get_csv3c($file_path){
	
	$row = 1;
                    
                 //read th
   
                
	if (($temp = fopen($file_path, "r")) !== FALSE) {
		
                                 //replace_spec_characters($file_path);
                                 
                            
                                  
                                   
		while (($data = fgetcsv($temp, 1000)) !== FALSE) {
			if($row == 1){ $row++; continue; } /*to jump first line of csv which should only 
			contain the headers from the columns of the original spreadsheet file*/
			  
			//setlocale(LC_ALL, 'es_ES'); /* This is to try to get the special characters from different languages */
			
			$number = count($data);			//echo "<p>". $number." of fields on  row  $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $number; $c++) {
				//echo $data[$c] . "<br />";
				if ($data[$c]==null){$c++;
				continue;}
				
				
				$result[$row][$c]=$data[$c];  /*Here we create and initialise the result returned by function with header and value */
			}
		}
		fclose($temp);
	}
	else {
		
		  echo ( "error reading file") ;   
		
	}
	return $result;
}

function get_csv3($f){
echo "<html><body><table>\n\n";
//$f = fopen("so-csv.csv", "r");
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></body></html>";
}
function replace_spec_characters($file_path){
    
    
                                     $str=file_get_contents($file_path);
                                     
                                   
                                    //replace ñ 
                                    $str=str_replace("ñ", "n",$str);    
                                    $str=str_replace("ç", "c",$str);    
                                    
                                     $str= file_put_contents($file_path, $str);
    
    
    return 1;
}

/*FOR EXPORTING CSV */
function array2csv_header(array &$array,array $header){

   $fp = fopen("php://output", "w");
   fputcsv ($fp, $header, "\t");
   //fputs($fp,"\t");

   foreach($array as $row){
        fputcsv($fp, $row, "\t");
   }
   fclose($fp);
return $fp;
    
}
function array2csv_header2(array &$array,array $header){


//$fp = fopen('fichero.csv', 'w');
 $fp = fopen("php://output", "w");
  fputcsv ($fp, $header);
foreach ($array as $campos) {
    fputcsv($fp, $campos);
}

fclose($fp);
//return $fp;
}

function array2csv_header5(array $array,array $header){

if (count($array) == 0) {
     return null;
   }
   //ob_start();
   
    $fp = fopen("php://output", "w");
    
    fputcsv ($fp, $header);
    
    foreach ($array as $campos) 
    
    {
        
    fputcsv($fp, $campos,"\t");
        
    }

   // fclose($fp);
}

function testFileO(array &$values,array $header){
    
    //$fp = fopen("php://output", "w");
    //file_put_contents ( $fp, $array);
    
     foreach($values as $row){
         
        file_put_contents("php://output", $row);
   }
    
    
    
    //fclose($fp);
}
function array2csv(array &$array){
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   
   return ob_get_clean();
}
function array3csv(array &$array){
   if (count($array) == 0) {
     return null;
   }
  // ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   
  // return ob_get_clean();
}
function array2csv4excel(array &$array,$filename){
	
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df); 
   $fp = fopen($filename, 'w');  
   fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
   return ob_get_clean();	

  
   //add BOM to fix UTF-8 in Excel


}
function array2csv_2d(array &$array){
    
   $header = array_keys(reset($array));

   $fp = fopen("php://output", "w");
   fputcsv ($fp, $header);
   foreach($array as $row){
        fputcsv($fp, $row, "\t");
   }
   fclose($fp);    
}
function download_csv($filename) {

 header("Content-Type: text/csv");
  header('Content-disposition: attachment;filename=mycoolfile.csv');
}
function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}
?>