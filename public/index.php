<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\RequestValidators\RegisterUserRequestValidator;

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$password2 = $_REQUEST['password2'];

$data = [
   'email'     => $email,
   'password'  => $password,
   'password2' => $password2,
];

$validator = new RegisterUserRequestValidator();
$validator->validate($data);


/*

 $link = mysqli_connect("register-db", "root", "root", "my_db");
    if (!$link) {
    echo json_encode([
    'success' => false,
    'error' => 'DB_error'
    ]);
    exit;
 }

 $result = mysqli_query($link, "SELECT * FROM user WHERE email = '$email'");
    if ($result && mysqli_num_rows($result)) {
    echo json_encode([
    'success' => false,
    'error' => 'password_mismatch'
    ]);
    exit;
 }

 mysqli_query($link, "INSERT INTO user SET email = '$email', password ='$password'");
    $userId = mysqli_insert_id($link);
    mail($email, 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite
    email adresu ...', 'adm@kupujemprodajem.com');
    mysqli_query($link, "INSERT INTO user_log SET `action` = 'register', user_id =
    $userId, log_time = NOW()");
    $_SESSION['userId'] = $userId;
    echo json_encode([
    'success' => true,
    'userId' => $userId
    ]); */

