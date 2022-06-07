<?php

namespace Tests\Repository;

use MyApp\model\User;
use MyApp\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use MyApp\Database\Database;

class UserRepositoryTest extends TestCase
{
    /**
     * @dataProvider searchByUserNameDataProvider
     * @return void
     */
    public function testSearchByUserName($param, $expected)
    {
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchByUserName($param)->getUserName();
        $this->assertEquals($expected, $result);
    }

    public function searchByUserNameDataProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>'anh',
              'expected'=>'anh'
          ]
        ];
    }

    public function testSearchByUserNameNull()
    {
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchByUserName('nhoc');
        $this->assertNull($result);
    }

    /**
     * @dataProvider searchByUserIdDataProvider
     * @return void
     */
    public function testSearchByUserId($param, $expected)
    {
        Database::databaseConnection();
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchById($param['id'])->getId();
        $this->assertEquals($expected, $result);
    }

    public function searchByUserIdDataProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>[
                'id'=>'1'
              ],
              'expected'=>'1'
          ]
        ];
    }

    public function testSearchByUserIdNull()
    {
        Database::databaseConnection();
        $user = new User();
        $userRepository = new UserRepository($user);
        $result = $userRepository->searchById('fsnk');
        $this->assertNull($result);
    }
}
