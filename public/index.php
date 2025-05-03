<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Shared\DatabaseConfiguration;
use App\Infrastructure\Persistence\PDOConnection;
use App\Infrastructure\Persistence\DatabaseUserRepository;
use App\Infrastructure\Persistence\DatabaseUserLogRepository;
use App\Infrastructure\Fraud\MaxMindFraudChecker;
use App\Presentation\Http\Controllers\RegisterController;
use App\Services\UserService;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$data = [
   'email'     => $_POST['email'],
   'password'  => $_POST['password'],
   'password2' => $_POST['password2'],
];

$config = new DatabaseConfiguration($_ENV);
$pdo = new PDOConnection($config->db);

$fraudCheckerStrategy = new MaxMindFraudChecker();

$userRepository = new DatabaseUserRepository($pdo);
$userLogRepository = new DatabaseUserLogRepository($pdo);
       
$userService = new UserService($userRepository, $userLogRepository, $fraudCheckerStrategy);

$controller = new RegisterController($userService);
$controller->register($data);
