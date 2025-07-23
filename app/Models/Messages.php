<?php

namespace App\Models;

use CodeIgniter\Model;

class Messages extends BaseModel
{
    protected $table = 'userchatmessages';
    protected $primaryKey = 'messageid';
    protected $allowedFields = ['messageid','sender_id', 'receiver_id', 'message', 'timestamp', 'read_status'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'timestamp';
    protected $updatedField = '';


    public function __construct()



    {



        parent::__construct();
       
    }

    public function getConversation($userId1, $userId2, $limit = 20, $offset = 0)
    {
        return $this->where(
            '(sender_id = ' . $this->db->escape($userId1) . ' AND receiver_id = ' . $this->db->escape($userId2) . ') OR ' .
            '(sender_id = ' . $this->db->escape($userId2) . ' AND receiver_id = ' . $this->db->escape($userId1) . ')'
        )
        ->orderBy('timestamp', 'ASC')
        ->findAll($limit, $offset);
    }



}