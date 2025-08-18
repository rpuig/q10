<?php

namespace App\Controllers;

use App\Libraries\RedisService;
use CodeIgniter\Controller;

class RedisTestController extends Controller
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new RedisService();
    }

    public function index()
    {
        // Test Redis connection
        try {
            // Set a test value
            $this->redis->set('test_key', 'Hello Redis!');
            
            // Get the value
            $value = $this->redis->get('test_key');
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Redis is working!',
                'test_value' => $value
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Redis error: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}