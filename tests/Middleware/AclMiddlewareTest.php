<?php

namespace Tests\Middleware;

use MyApp\App\Route;
use MyApp\Http\Request;
use MyApp\Middleware\AclMiddleware;
use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\service\TokenService;
use PHPUnit\Framework\TestCase;

class AclMiddlewareTest extends TestCase
{
    /**
     * @dataProvider verifyDataProvider
     * @return void
     */
    public function testVerifySection($param, $expected)
    {
        $_SERVER['REQUEST_METHOD'] = $param['REQUEST_METHOD'];
        $_SERVER['REQUEST_URI'] = $param['REQUEST_URI'];
        $_SESSION['userName'] = $param['userName'];

        $user = new User();
        $request = new Request();
        $tokenService = new TokenService();
        $userRepository = new UserRepository($user);
        $route = new Route();
        $route->getRoute();

        $acl = new AclMiddleware($request, $tokenService, $userRepository);
        $result = $acl->verify($route);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider verifyTokenDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testVerifyToken($param, $expected): void
    {
        $_SERVER['REQUEST_METHOD'] = $param['REQUEST_METHOD'];
        $_SERVER['REQUEST_URI'] = $param['REQUEST_URI'];
        $_SERVER['HTTP_AUTHORIZATION'] = $param['HTTP_AUTHORIZATION'];
        $route = new Route();
        $route->getRoute();

        $user = new User();
        $request = new Request();
        $tokenService = new TokenService();
        $userRepository = new UserRepository($user);

        var_dump($route);
        $acl = new AclMiddleware($request, $tokenService, $userRepository);
        $result = $acl->verify($route);
        $this->assertEquals($expected, $result);
    }

    public function verifyTokenDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=>[
                    'REQUEST_METHOD'=> 'POST',
                    'REQUEST_URI'=>'/api/cars',
                    'HTTP_AUTHORIZATION' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0aWQiOm51bGwsInN1YiI6IjEiLCJpYXQiOjE2NTQwNjUwMTR9.5TZugGVOi9TWFBmDUSJ6lqY560MW7r75nz5K2H5Hi_M',
                ],
                'expected'=>[]
            ],
            'unhappy-case-1'=>[
                'param'=>[
                    'REQUEST_METHOD'=> 'POST',
                    'REQUEST_URI'=>'/api/cars',
                    'HTTP_AUTHORIZATION' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0aWQiOm51bGwsInN1YiI6IjIiLCJpYXQiOjE2NTQ0OTc3NjR9.xrBekB4V_iSVd_whYqj0I1Utz7nQo3YNA95XoHds7nM',
                ],
                'expected'=>['User are not permitted']
            ]
        ];
    }

    public function verifyDataProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>[
                  'REQUEST_METHOD'=> 'POST',
                  'REQUEST_URI'=>'/cars',
                  'userName'=>'anh',
              ],
              'expected'=>[]
          ],
            'unhappy-case-1'=>[
                'param'=>[
                    'REQUEST_METHOD'=> 'POST',
                    'REQUEST_URI'=>'/cars',
                    'userName'=>'ngoc',
                ],
                'expected'=>['User are not permitted']
            ]
        ];
    }
}
