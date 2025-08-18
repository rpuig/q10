<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Redis extends BaseConfig
{
    /**
     * Default connection group
     */
    public string $default = 'default';

    /**
     * Redis connection groups
     */
    public array $connections = [
        'default' => [
            'host'     => 'redis',
            'password' => null,
            'port'     => 6379,
            'timeout'  => 0,
            'database' => 0,
        ],
        'cache' => [
            'host'     => 'redis',
            'password' => null,
            'port'     => 6379,
            'timeout'  => 0,
            'database' => 1,
        ],
        'session' => [
            'host'     => 'redis',
            'password' => null,
            'port'     => 6379,
            'timeout'  => 0,
            'database' => 2,
        ],
    ];
}