<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     *
     * @var string
     */public $default;
    public $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     *
     * @var string
     */
    public $defaultGroup= 'default';

    /**
     * The default database connection.
     *
     * @var array
     */
    /* public array $default = [
        'DSN'      => '',

        'hostname' => '',
        'username' => '',

        'password' =>'',

        'database' =>'',

        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
        'saveQueries' => true,

    ]; */

    

    public array $development = [
        'DSN'      => '',
        'hostname' =>'',
        'username' => '',
        'password' => '',
        'database' =>'',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
        'saveQueries' => true,

    ];

    public array $production = [
        'DSN'      => '',
       'hostname' =>'',
        'username' => '',
        'password' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => false,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress'  => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     *
     * @var array
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
        'pConnect'    => false,
        'DBDebug'     => (ENVIRONMENT !== 'production'),
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
    ];







    public function __construct()
    {


        $this->default  = [
            'DSN'      => env('database.default.DSN', ''),
            'hostname' => '',
            'username' => env('database.default.username', 'root'),
            'password' => env('database.default.password', ''),
            'database' => '',
            'DBDriver' => 'Postgre',
            'port'     => 5432,
            'pConnect' => false,
            'DBDebug'  => true,
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'saveQueries' => true,
        ];
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }

/*
        $this->default['hostname'] = env('DB_DEFAULT_HOSTNAME');
        $this->default['username'] = env('DB_DEFAULT_USERNAME');
        $this->default['password'] = env('DB_DEFAULT_PASSWORD');
        $this->default['database'] = env('DB_DEFAULT_DATABASE');


        $this->development['hostname'] = env('DB_DEVELOPMENT_HOSTNAME');
        $this->development['username'] = env('DB_DEVELOPMENT_USERNAME');
        $this->development['password'] = env('DB_DEVELOPMENT_PASSWORD');
        $this->development['database'] = env('DB_DEVELOPMENT_DATABASE');


        $this->production['hostname'] = env('DB_PRODUCTION_HOSTNAME');
        $this->production['username'] = env('DB_PRODUCTION_USERNAME');
        $this->production['password'] = env('DB_PRODUCTION_PASSWORD');
        $this->production['database'] = env('DB_PRODUCTION_DATABASE');*/

       


    }
}
