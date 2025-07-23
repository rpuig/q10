<?php
include('../header.php');
include('../profile.php');
include('../db/db.php');

// Create a new database instance and make a connection
$database = new db(HOST, USER, PASSWORD, DATABASE);
$table_name = "birth_info";
$conn = $database->makeconnection();

// Get the number of rows in the table
$row_nbr = $database->get_table_num_rows($table_name, $conn);

$final_array = [];
$header_added = false;

// Iterate through each row in the database table
for ($i = 1; $i <= $row_nbr; $i++) {
    $row = $database->get_row($i, $table_name, $conn);
    $prof = new Profile($row);

    // Get profile data for CSV export
    $profileData = $prof->export_profile_csv();

    // Add headers if not added yet
    if (!$header_added) {
        $headers = array_keys($profileData);
        $final_array[] = $headers;
        $header_added = true;
    }

    // Append the profile data as a new row in the final array
    $final_array[] = array_values($profileData);
}

// Prepare to write to CSV file
$filename = getcwd() . '/profile_export.csv';
$fp = fopen($filename, 'w');

if ($fp === false) {
    $error = error_get_last();
    echo "Could not open file '$filename'. Error: " . $error['message'];
} else {
    // Write each array as a row to the CSV file
    foreach ($final_array as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp); // Close the file after writing
}
