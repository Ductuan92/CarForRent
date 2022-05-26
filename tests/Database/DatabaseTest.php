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
}
