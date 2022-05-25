<?php

namespace MyApp\Database;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO
     */
    private static PDO $connection;

    /**
     * @return PDO
     */
    public static function databaseConnection()
    {

        if(empty(static::$connection))
        {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();

            try{
                static::$connection = new PDO($_ENV['DB_DSN'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

                // set the PDO error mode to exception
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully";
            }
            catch(PDOException $e){
                echo  $e->getMessage();
            }
        }
        return static::$connection;
    }
}
