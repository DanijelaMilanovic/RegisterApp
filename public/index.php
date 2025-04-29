<?php

$email = 'john1.doe@example.com';
$password = 'password';
$password2 = 'password';

if (empty($email)) {
    echo json_encode([
    'success' => false,
    'error' => 'email'
]);

exit;
}

if (!preg_match('/^[^@\\s]+@[^@\\s]+\\.[^@\\s]+$/', $email)) {
    echo json_encode([
    'success' => false,
    'error' => 'email_format'
    ]);
    exit;
}

if (empty($password) || mb_strlen($password) < 8) {
    echo json_encode([
    'success' => false,
    'error' => 'password'
    ]);
    exit;
 }
 
 if (empty($password2) || mb_strlen($password) < 8) {
    echo json_encode([
    'success' => false,
    'error' => 'password2'
    ]);
    exit;
 }

 if ($password != $password2) {
    echo json_encode([
    'success' => false,
    'error' => 'password_mismatch'
    ]);
    exit;
 }

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
    ]);
