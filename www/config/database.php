<?php
if(!empty(parse_ini_file(public_path('../../config.ini'))['database'])) {
    /** Si la localisation de la base de donnée dans le fichier ini est compélté, alors on utilise ce chemin absolu */
    $sqlitedb = parse_ini_file(public_path('../../config.ini'))['database'];
} else {
    /** Si la localisation de la base de donnée dans le fichier ini est vide, alors on utilise un chemin relatif */
    $sqlitedb = storage_path('database/gdmc.db');
}

return [

    /*
      |--------------------------------------------------------------------------
      | PDO Fetch Style
      |--------------------------------------------------------------------------
      |
      | By default, database results will be returned as instances of the PHP
      | stdClass object; however, you may desire to retrieve records in an
      | array format for simplicity. Here you can tweak the fetch style.
      |
    */

    'fetch' => PDO::FETCH_OBJ,

        /*
          |--------------------------------------------------------------------------
          | Default Database Connection Name
          |--------------------------------------------------------------------------
          |
          | Here you may specify which of the database connections below you wish
          | to use as your default connection for all database work. Of course
          | you may use many connections at once using the Database library.
          |
        */

        'default' => env('DB_CONNECTION', 'sqlite'),

        /*
          |--------------------------------------------------------------------------
          | Database Connections
          |--------------------------------------------------------------------------
          |
          | Here are each of the database connections setup for your application.
          | Of course, examples of configuring each database platform that is
          | supported by Laravel is shown below to make development simple.
          |
          |
          | All database work in Laravel is done through the PHP PDO facilities
          | so make sure you have the driver for your particular database of
          | choice installed on your machine before you begin development.
          |
        */

        'connections' => [

            'sqlite' => [
                'driver' => 'sqlite',
                    'database' => $sqlitedb,
                    'prefix' => '',
                    'exec' => 'PRAGMA foreign_keys = ON;', // enabling cascade
                    ],

                'mysql' => [
                    'driver' => 'mysql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '3306'),
                        'database' => env('DB_DATABASE', 'forge'),
                        'username' => env('DB_USERNAME', 'forge'),
                        'password' => env('DB_PASSWORD', ''),
                        'charset' => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                        'prefix' => '',
                        'strict' => true,
                        'engine' => null,
                        ],

                'pgsql' => [
                    'driver' => 'pgsql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '5432'),
                        'database' => env('DB_DATABASE', 'forge'),
                        'username' => env('DB_USERNAME', 'forge'),
                        'password' => env('DB_PASSWORD', ''),
                        'charset' => 'utf8',
                        'prefix' => '',
                        'schema' => 'public',
                        'sslmode' => 'prefer',
                        ],

                ],

        /*
          |--------------------------------------------------------------------------
          | Migration Repository Table
          |--------------------------------------------------------------------------
          |
          | This table keeps track of all the migrations that have already run for
          | your application. Using this information, we can determine which of
          | the migrations on disk haven't actually been run in the database.
          |
        */

        'migrations' => 'migrations',

        /*
          |--------------------------------------------------------------------------
          | Redis Databases
          |--------------------------------------------------------------------------
          |
          | Redis is an open source, fast, and advanced key-value store that also
          | provides a richer set of commands than a typical key-value systems
          | such as APC or Memcached. Laravel makes it easy to dig right in.
          |
        */

        'redis' => [

            'cluster' => false,

                'default' => [
                    'host' => env('REDIS_HOST', '127.0.0.1'),
                        'password' => env('REDIS_PASSWORD', ''),
                        'port' => env('REDIS_PORT', 6379),
                        'database' => 0,
                        ],

                ],

        ];
