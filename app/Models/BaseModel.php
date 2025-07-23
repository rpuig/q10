<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $DBGroup = 'default'; // Default database group

    public function __construct()
    {
        parent::__construct();
        // Optionally initialize other services here if needed
        // $this->session = \Config\Services::session();
        // $this->uri = new \CodeIgniter\HTTP\URI(current_url(true));
       if(env("database.default.DBDriver" )==="Postgre") $this->db->query("SET search_path TO xgroups");

    }

    public function setDbGroup($group)
    {
        $this->DBGroup = $group;
        $this->db = \Config\Database::connect($this->DBGroup);
    }

    public function updateUserField($userId, $field, $value)
    {
        log_message('debug', "Updating user field: userId = $userId, field = $field, value = $value");

        $data = [
            'userid' => $userId,
            $field => $value,
        ];

        // Assuming 'userID' is the primary key and the table is correctly set
        $result = $this->update($userId, $data);

        log_message('debug', "Update result: " . var_export($result, true));
        return $result;
    }
}
