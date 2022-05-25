<?php

namespace MyApp\Repository;

use MyApp\Database\Database;
use MyApp\model\User;
use PDO;

class UserRepository
{
    private User $user;
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param $connection
     */
    public function __construct(User $user)
    {
        $this->user = new User();
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
            if ($row = $statement->fetch()) {
                $this->user->setId($row['id']);
                $this->user->setUserName($row['user_name']);
                $this->user->setPassword($row['password']);
                $this->user->setEmail($row['email']);
                $this->user->setRole($row['role']);
                return $this->user;
            }
        }
        finally{
                $statement->closeCursor();
            }
    }

    public function searchById($id)
    {

        $statement = $this->connection->prepare("SELECT * FROM user WHERE id = ? ");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $this->user->setId($row['id']);
                $this->user->setUserName($row['user_name']);
                $this->user->setPassword($row['password']);
                $this->user->setEmail($row['email']);
                $this->user->setRole($row['role']);
                return $this->user;
            }
        }
        finally{
            $statement->closeCursor();
        }
    }
}
