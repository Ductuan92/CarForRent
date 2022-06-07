<?php

namespace Tests\service;

use MyApp\Http\Request;
use MyApp\service\FileService;
use PHPUnit\Framework\TestCase;

class FileServiceTest extends TestCase
{
    /**
     * @dataProvider uploadToS3DataProvider
     * @return void
     */
    public function testUploadToS3Fail($param, $expected)
    {
        $_SERVER['REQUEST_METHOD'] = $param['METHOD'];
        $file = ['name'=>$param['name'],
            'error'=>$param['error'],
            'type'=>$param['type'],
            'size'=>$param['size'],
            'tmp_name'=> $param['tmp_name']
                ];
        $fileService = new FileService();
        $result = $fileService->uploadToS3($file);
        $this->assertEquals($expected, $result);
    }

    public function uploadToS3DataProvider()
    {
        return [
          'unhappy-case-1'=>[
              'param'=>[
                  'METHOD'=>'POST',
                  'name'=>'1.jpeg',
                  'error'=>0,
                  'type'=>'image/jpeg',
                  'size'=>9604,
                  'tmp_name'=> '/private/var/tmp/phpOL1vpw'
              ],
              'expected'=> ['error' => 'There was an error!!']
          ],
            'unhappy-case-2'=>[
                'param'=>[
                    'METHOD'=>'GET',
                    'name'=>'1.jpeg',
                    'error'=>0,
                    'type'=>'image/jpeg',
                    'size'=>9604,
                    'tmp_name'=> '/private/var/tmp/phpOL1vpw'
                ],
                'expected'=> ['error' => 'Invalid request method']
            ],
        ];
    }
}
