<?php

namespace MyApp\service;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Dotenv\Dotenv;
use MyApp\Http\Request;
use phpDocumentor\Reflection\Type;

class FileService
{
    private static $loadEnv;
    private static string $path = "../public/assets/img/";

    public function __construct()
    {
        self::$loadEnv = Dotenv::createImmutable(dirname(__DIR__));
        self::$loadEnv->load();

    }

    public function uploadToS3($file): array|string
    {
        $bucketName = $_ENV['S3_BUCKET_NAME'];
        $filename = md5(date('Y-m-d H:i:s:u')) . $file["name"];
        $s3Client = $this->connectS3();
        $message = $this->verifyImage($file, $filename);
        if($message){
            return $message;
        }
        return $this->upload($s3Client, $file, $filename, $bucketName);
    }

    /**
     * @return S3Client
     */
    private function connectS3(): S3Client
    {
        $bucketRegion = $_ENV['S3_BUCKET_REGION'];
        $accessKey = $_ENV['S3_ACCESS_KEY_ID'];
        $secretKey = $_ENV['S3_SECRET_ACCESS_KEY'];
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $bucketRegion,
            'credentials' => ['key' => $accessKey, 'secret' => $secretKey]
        ]);

        return $s3Client;
    }

    /**
     * @param $file
     * @return string|string[]
     */
    private function verifyImage($file, $filename): string|array
    {
        $result = $this->verifyEmptyImage($file);
        $result = array_merge($result, $this->verifyMethod());
        $result = array_merge($result, $this->verifyFormat($file, $filename));
        return array_merge($result, $this->verifySize($file));
    }

    private function verifyEmptyImage($file): array
    {
        if (!isset($file) || $file["error"] != 0) {
            return ['error' => 'File upload does not exist'];
        }
        return [];
    }

    private function verifyMethod(): array
    {
        if (Request::requestMethod() != "POST") {
            return ['error' => 'Invalid request method'];
        }
        return [];
    }

    private function verifySize($file): array
    {

        $filesize = $file["size"];
        $maxsize = 10 * 2024 * 2024;

        if ($filesize > $maxsize) {
            return ['error' => 'File size is larger than the allowed limit'];
        }
        return [];
    }
    private function verifyFormat($file, $filename,): array
    {
        $allowed = [
            "jpg" => "image/jpg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "png" => "image/png"
        ];
        $filetype = $file["type"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed)) {
            return ['error' => 'Please select a valid file format'];
        }
        return [];
    }

    private function upload($s3Client, $file, $filename, $bucketName)
    {
        if (move_uploaded_file($file["tmp_name"], self::$path . $filename)) {
            $file_Path = self::$path . $filename;
            $key = basename($file_Path);
            return $this->uploadS3($s3Client, $bucketName, $filename, $file_Path, $key);
        } else {
            return ['error' => 'There was an error!!'];
        }
    }

    private function uploadS3($s3Client, $bucketName, $filename, $file_Path, $key): array|string
    {
        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $key,
                'SourceFile' => $file_Path,
            ]);
            unlink(self::$path . $filename);
            return $result->get('ObjectURL');
        } catch (S3Exception $e) {
            return ['error' => 'Error when upload image to S3!!!' . $e->getMessage()];
        }
    }
}
