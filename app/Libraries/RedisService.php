<?php

namespace App\Libraries;

use Config\Redis as RedisConfig;

class RedisService
{
    protected $redis;
    protected $config;

    public function __construct(string $connection = 'default')
    {
        $this->config = config('Redis')->connections[$connection];
        
        $this->redis = new \Redis();
        $this->connect();
    }

    protected function connect()
    {
        try {
            $this->redis->connect(
                $this->config['host'],
                $this->config['port'],
                $this->config['timeout']
            );

            if ($this->config['password']) {
                $this->redis->auth($this->config['password']);
            }

            if (isset($this->config['database'])) {
                $this->redis->select($this->config['database']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Redis connection failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function set($key, $value, $ttl = null)
    {
        if ($ttl) {
            return $this->redis->setex($key, $ttl, $value);
        }
        return $this->redis->set($key, $value);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function delete($key)
    {
        return $this->redis->del($key);
    }

    public function exists($key)
    {
        return $this->redis->exists($key);
    }

    public function increment($key, $value = 1)
    {
        return $this->redis->incrBy($key, $value);
    }

    public function decrement($key, $value = 1)
    {
        return $this->redis->decrBy($key, $value);
    }

    public function expire($key, $ttl)
    {
        return $this->redis->expire($key, $ttl);
    }

    public function flush()
    {
        return $this->redis->flushDB();
    }
}