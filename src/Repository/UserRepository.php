<?php

namespace MyApp\Repository;

use MyApp\Database\Database;
use MyApp\model\User;
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
     * @return User|null
     */
    public function searchByUserName($userName): User|null
    {

        $statement = $this->connection->prepare("SELECT * FROM user WHERE username = ? ");
        $statement->execute([$userName]);
        $row = $statement->fetch();
        $statement->closeCursor();

        if($row){
            return $this->setUser($row);
        }
        return null;
    }

    /**
     * @param $id
     * @return User|null
     */
    public function searchById($id): User|null
    {

        $statement = $this->connection->prepare("SELECT * FROM user WHERE id = ? ");
        $statement->execute([$id]);
        $row = $statement->fetch();
        $statement->closeCursor();

        if($row){
            return $this->setUser($row);
        }
        return null;
    }

    /**
     * @param $row
     * @return User
     */
    private function setUser($row):User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUserName($row['username']);
        $user->setPassword($row['password']);
        $user->setEmail($row['email']);
        $user->setRole($row['role']);
        return $user;
    }
}
