<?php

namespace App\Libraries;

use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\Consumer;
use RdKafka\TopicConf;

class KafkaService
{
    protected $producer;
    protected $consumer;
    protected $config;

    public function __construct()
    {
        $this->config = [
            // Match docker-compose-dev.yml advertised listener for inter-container access
            'bootstrap.servers' => 'kafka:9092',
            'group.id' => 'myapp-group',
            'auto.offset.reset' => 'earliest',
            'socket.timeout.ms' => 50000,
            'message.timeout.ms' => 50000,
            'enable.auto.commit' => 'true',
            'debug' => 'all'
        ];
    }

    public function createProducer()
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', $this->config['bootstrap.servers']);

        $this->producer = new Producer($conf);
        return $this->producer;
    }

    public function createConsumer()
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', $this->config['bootstrap.servers']);
        $conf->set('group.id', $this->config['group.id']);
        $conf->set('auto.offset.reset', $this->config['auto.offset.reset']);

        $this->consumer = new \RdKafka\KafkaConsumer($conf);
        return $this->consumer;
    }

    public function publish($topic, $message, $key = null)
    {
        try {
            if (!$this->producer) {
                $this->createProducer();
            }

            $topic = $this->producer->newTopic($topic);
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($message), $key);
            $this->producer->flush(10000);

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Kafka producer error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function subscribe($topics)
    {
        try {
            if (!$this->consumer) {
                $this->createConsumer();
            }

            $this->consumer->subscribe($topics);
        } catch (\Exception $e) {
            log_message('error', 'Kafka consumer error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function consume($timeout = 120000)
    {
        try {
            // Convert total timeout (ms) into polling loop with 1s polls
            $end = microtime(true) + ($timeout / 1000);
            while (microtime(true) < $end) {
                $message = $this->consumer->consume(1000); // 1s
                if ($message === null) {
                    continue;
                }

                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        return [
                            'payload' => json_decode($message->payload, true),
                            'key' => $message->key,
                            'topic' => $message->topic_name,
                            'partition' => $message->partition,
                            'offset' => $message->offset,
                            'timestamp' => $message->timestamp
                        ];

                    case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                        // no more messages in this partition for now
                        break;

                    case RD_KAFKA_RESP_ERR__TIMED_OUT:
                        // poll again
                        break;

                    default:
                        throw new \Exception($message->errstr(), $message->err);
                }
            }

            // timed out without receiving a message
            return null;
        } catch (\Exception $e) {
            log_message('error', 'Kafka consume error: ' . $e->getMessage());
            throw $e;
        }
    }
}