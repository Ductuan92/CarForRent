<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use MyApp\App\Application;

error_reporting(E_ALL);
ini_set('display_errors', '1');

$application = new Application();
$application->start();
