<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Shared\DatabaseConfiguration;
use App\Shared\Exceptions\DuplicateException;
use App\Shared\Exceptions\FraudException;
use App\Shared\Exceptions\MailException;
use App\Shared\Exceptions\ValidationException;
use App\Infrastructure\Persistence\PDOConnection;
use App\Infrastructure\Persistence\PDOUserRepository;
use App\Infrastructure\Persistence\PDOUserLogRepository;
use App\Infrastructure\Fraud\MaxMindFraudChecker;
use App\Infrastructure\Mail\SmtpMailer;
use App\Presentation\Http\Controllers\RegisterController;
use App\Presentation\Http\JsonResponse;
use App\Services\UserService;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$data = [
   'email'   => filter_input(INPUT_POST, 'email') ?? null,
   'password'  => filter_input(INPUT_POST, 'password') ?? null,
   'password2' => filter_input(INPUT_POST, 'password2') ?? null,
];

$config = new DatabaseConfiguration($_ENV);
$pdo = new PDOConnection($config->db);

$fraudChecker = new MaxMindFraudChecker();

$mailer = new SmtpMailer($_ENV['MAIL_FROM']);

$userRepository = new PDOUserRepository($pdo);
$userLogRepository = new PDOUserLogRepository($pdo);
       
$userService = new UserService($userRepository, $userLogRepository, $fraudChecker, $mailer);

$controller = new RegisterController($userService);

try {
    $controller->register($data);
} catch (ValidationException $e) {
   JsonResponse::validationError($e->getErrors());
} catch (FraudException $e) {
   JsonResponse::forbidden($e->getMessage());
} catch (DuplicateException $e) {
   JsonResponse::conflict($e->getMessage());
} catch (MailException $e) {
   JsonResponse::internalServerError($e->getMessage());
} catch (Exception $e) {
   JsonResponse::internalServerError($e->getMessage());
}
