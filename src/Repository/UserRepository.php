<?php

namespace MyApp\Repository;

use MyApp\Database\Database;
use PDO;

class UserRepository
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param $connection
     */
    public function __construct()
    {
        $this->connection = Database::databaseConnection();
    }

    /**
     * @param $userName
     * @return mixed|void
     */
    public function searchByUserName($userName)
    {

        $statement = $this->connection->prepare("SELECT * FROM user WHERE user_name = ? ");
        $statement->execute([$userName]);

        try {
            if ($row = $statement->fetch()) {;
                return $row;
            }
        }
        finally{
                $statement->closeCursor();
            }
    }
}
