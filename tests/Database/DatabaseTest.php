<?php

namespace Tests\Database;

use MyApp\Database\Database;
use PHPUnit\Framework\TestCase;
use PDOException;
use PDO;
class DatabaseTest extends TestCase
{
    public function testDatabase()
    {
        $connection = Database::databaseConnection();
        $this->assertNotNull($connection);
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
//    public function testDatabaseFalse()
//    {
//        Database::databaseConnection();
//        Database::$pdo = ['DB_DSN'=>'mysql:host=localhost;dbname=db',
//            'DB_USERNAME'=>'anh',
//            'DB_PASSWORD'=>'daa'];
//        $this->expectException(PDOException::class);
//        $connection = Database::databaseConnection();
//    }
}
