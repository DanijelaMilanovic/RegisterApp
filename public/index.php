<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\JsonResponse;
use App\Exceptions\ValidationException;
use App\Infrastructure\MaxMindFraudChecker;
use App\RequestValidators\RegisterUserRequestValidator;
use App\Core\DatabaseConfiguration;
use App\Core\PDOConnection;
use App\Persistence\DatabaseUserRepository;
use App\Persistence\DatabaseUserLogRepository;
use App\Entities\UserLog;
use App\Entities\User;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$data = [
   'email'     => $_REQUEST['email'],
   'password'  => $_REQUEST['password'],
   'password2' => $_REQUEST['password2'],
];

$validator = new RegisterUserRequestValidator();
try {
   $validator->validate($data);
} catch (ValidationException $e) {
   return JsonResponse::validationError($e->getErrors());
}

$checker = new MaxMindFraudChecker();
$fraudCheck = $checker->checkFraud($data['email'], $_SERVER['REMOTE_ADDR']);

if($fraudCheck) {
   return JsonResponse::forbidden('Request denied!');
}

$config = new DatabaseConfiguration($_ENV);
$pdo = new PDOConnection($config->db);

$userRepository = new DatabaseUserRepository($pdo);

if($userRepository -> findByEmail($data['email']) !== null) {
   return JsonResponse::badRequest('Email already exists!');
}

$user = new User(
   null,
   $data['email'],
   $data['password']
);

$newUser = $userRepository ->create($user);

mail($user->getEmail(), 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...', 'adm@kupujemprodajem.com');

$userLogRepository = new DatabaseUserLogRepository($pdo);
$userLog = new UserLog(
   null,
   'register',
   null,
   $newUser->getId()
);

$newUserLog = $userLogRepository->create($userLog);

$_SESSION['userId'] = $user->getId();

return JsonResponse::ok(['userId' => $newUser->getId()]);
