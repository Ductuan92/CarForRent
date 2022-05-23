<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use MyApp\App\Application;

$application = new Application();
$application->start();
