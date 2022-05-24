<?php

namespace MyApp\model;

class User
{
    /**
     * @var int
     */
    private int  $id;

    /**
     * @var string
     */
    private string $userName;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $email;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return void
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param $userName
     * @return void
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return void
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
