<?php

namespace App\Controllers;

use App\Libraries\KafkaService;
use CodeIgniter\Controller;

class KafkaTestController extends Controller
{
    protected $kafka;

    public function __construct()
    {
        $this->kafka = new KafkaService();
    }

    public function produce()
    {
        try {
            $message = [
                'id' => uniqid(),
                'message' => 'Test message',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            $this->kafka->publish('test-topic', $message);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Message published successfully',
                'data' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function consume()
    {
        try {
            $this->kafka->subscribe(['test-topic']);
            $message = $this->kafka->consume(5000); // 5 second timeout

            if ($message === null) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No messages available in topic',
                    'hint' => 'Try producing a message first at /kafka/produce'
                ])->setStatusCode(404);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Message consumed successfully',
                'data' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'hint' => 'Make sure Kafka and Zookeeper are running'
            ])->setStatusCode(500);
        }
    }
}