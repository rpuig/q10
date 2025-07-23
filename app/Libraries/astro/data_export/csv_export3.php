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
    //add styles 
    $highestColumn = $sheet->getHighestColumn();
    $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray($headerStyleArray);

    $colIndex = 'A';
    foreach ($profileData as $value) {
        $sheet->setCellValue($colIndex++ . $rowIndex, $value);
        $sheet->getStyle($colIndex++ . $rowIndex)->applyFromArray($headerStyleArray);

    }


    $rowIndex++;
}

$writer = new Ods($spreadsheet);
$filename = getcwd() . '/profile_export.ods';
$writer->save($filename);
