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
    private User $user;

    /**
     * @param $connection
     */
    public function __construct(User $user)
    {
        $this->connection = Database::databaseConnection();
        $this->user = $user;
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
            $this->setUser($row);
            return $this->user;
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
            $this->setUser($row);
            return $this->user;
        }
        return null;
    }

    /**
     * @param $row
     * @return void
     */
    private function setUser($row):void
    {
        $this->user = new User();
        $this->user->setId($row['id']);
        $this->user->setUserName($row['username']);
        $this->user->setPassword($row['password']);
        $this->user->setEmail($row['email']);
        $this->user->setRole($row['role']);
    }
}
