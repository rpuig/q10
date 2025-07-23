<?php namespace App\Controllers\Utils;

use CodeIgniter\Controller;
use Config\Database;

class QueryLogger extends Controller 
{
    public function logLastQuery()
    {
        // Get the database connection
        $db = Database::connect();

        // Get the last query
        $lastQuery = $db->getLastQuery();

        // Print the last query to the screen
       // echo "Last Query: " . $lastQuery;

        // Optionally, you can also log it
        log_message('info', 'Last Query: ' . $lastQuery);
    }
}