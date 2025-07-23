<?php

require '../vendor/autoload.php'; // Adjust the path as needed for your Composer autoload file

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

include('../header.php');
include('../profile.php');
include('../db/db.php');
include('ods_formatting.php');
// Database and table setup
$database = new db(HOST, USER, PASSWORD, DATABASE);
$table_name = "birth_info";
$conn = $database->makeconnection();

$row_nbr = $database->get_table_num_rows($table_name, $conn);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$header_added = false;
$rowIndex = 1;

for ($i = 1; $i <= $row_nbr; $i++) {
    $row = $database->get_row($i, $table_name, $conn);
    $prof = new Profile($row);
    $profileData = $prof->export_profile_csv();

    if (!$header_added) {
        $headers = array_keys($profileData);
        $colIndex = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($colIndex++ . $rowIndex, $header);
        }
        $header_added = true;
        $rowIndex++;
    }

    // Apply header styles (outside of the loop)
    if ($rowIndex == 2) {
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray($headerStyleArray);
    }

    $colIndex = 'A';
    foreach ($profileData as $key => $value) {
        $cell = $colIndex . $rowIndex;
        $sheet->setCellValue($cell, $value);
        //$cell=$colIndex .":". $rowIndex;
        // Apply conditional formatting

        switch ($value) {
            case 'yang water':
                $sheet->getStyle($cell)->applyFromArray($styles['YangWater']);
                break;
            case 'yin water':
                $sheet->getStyle($cell)->applyFromArray($styles['YinWater']);
                break;
            case 'yang wood':
                $sheet->getStyle($cell)->applyFromArray($styles['YangWood']);
                break;
            case 'yin wood':
                $sheet->getStyle($cell)->applyFromArray($styles['YinWood']);
                break;
            case 'yang fire':
                $sheet->getStyle($cell)->applyFromArray($styles['YangFire']);
                break;
            case 'yin fire':
                $sheet->getStyle($cell)->applyFromArray($styles['YinFire']);
                break;
            case 'yang earth':
                $sheet->getStyle($cell)->applyFromArray($styles['YangEarth']);
                break;
            case 'yin earth':
                $sheet->getStyle($cell)->applyFromArray($styles['YinEarth']);
                break;
            case 'yang metal':
                $sheet->getStyle($cell)->applyFromArray($styles['YangMetal']);
                break;
            case 'yin metal':
                $sheet->getStyle($cell)->applyFromArray($styles['YinMetal']);
                break;

            case 'elm_level_str': // This case seems to be out of place. If 'elm_level_str' is a key, not a value, it should be handled outside of the switch.
                $styleArray = getStyleBasedOnCellValue($value, $styles);
                // Apply the style to the cell
                $sheet->getStyle($cell)->applyFromArray($styleArray);
                break;

            case 'warrior': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Yellow']); // Assuming 'Warrior' style is defined in your styles array
                break;
            case 'human': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Yellow']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'star': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Yellow']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'seed': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Yellow']); // Assuming 'Warrior' style is defined in your styles array
                break;      
            case 'sun': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Yellow']); // Assuming 'Warrior' style is defined in your styles array
                break;      

            case 'eagle': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Blue']); // Assuming 'Warrior' style is defined in your styles array
                break;
            case 'night': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Blue']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'hand': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Blue']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'monkey': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Blue']); // Assuming 'Warrior' style is defined in your styles array
                break;      
            case 'storm': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Blue']); // Assuming 'Warrior' style is defined in your styles array
                break;   

            case 'earth': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Red']); // Assuming 'Warrior' style is defined in your styles array
                break;
            case 'skywalker': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Red']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'dragon': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Red']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'moon': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Red']); // Assuming 'Warrior' style is defined in your styles array
                break;      
            case 'snake': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['Red']); // Assuming 'Warrior' style is defined in your styles array
                break;                     
      

            case 'wind': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['White']); // Assuming 'Warrior' style is defined in your styles array
                break;
            case 'mirror': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['White']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'wizard': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['White']); // Assuming 'Warrior' style is defined in your styles array
                break;            
            case 'worldBridger': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['White']); // Assuming 'Warrior' style is defined in your styles array
                break;      
            case 'dog': // Assuming 'warrior' is another valid case
                $sheet->getStyle($cell)->applyFromArray($styles['White']); // Assuming 'Warrior' style is defined in your styles array
                break;            



            default:
                // Apply other conditional formatting as needed
                // The $key variable is not accessible inside the switch for $value. If this check is necessary, it should be done outside the switch.
                break;
        }

        $colIndex++;
    }

    $rowIndex++;
}




$writer = new Ods($spreadsheet);
$filename = getcwd() . '/profile_export.ods';
$writer->save($filename);
