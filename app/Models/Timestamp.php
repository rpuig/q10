<?php namespace App\Models;

use CodeIgniter\Model;

class Timestamp extends BaseModel
{
    protected $DBGroup = 'default'; // Use the default database group
    protected $table = 'your_table'; // Table name if needed for other operations
    protected $primaryKey = 'id'; // Primary key if needed for other operations

    // Define a method to get the server timestamp
    
    
    
    public function getServerTimestamp()
    {
        $builder = $this->db->table('pg_stat_activity'); // Not necessary, but just an example
        $query = $this->db->query('SELECT current_timestamp AS server_time');
        return $query->getRow()->server_time;
    }
}