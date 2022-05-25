<?php

namespace Tests\Repository;

use MyApp\model\User;
use MyApp\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use MyApp\Database\Database;

class UserRepositoryTest extends TestCase
{
    public function testSearchByUserName()
    {
        Database::databaseConnection();
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchByUserName('anh')->getUserName();
        $this->assertEquals('anh', $result);
    }

    public function testSearchByUserId()
    {
        Database::databaseConnection();
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchById('1')->getId();
        $this->assertEquals('1', $result);
    }
}
