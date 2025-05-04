<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\User;
use App\Domain\UserLog;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserLogRepository;
use App\Services\Dtos\UserRegisterDto;
use App\Shared\Exceptions\DuplicateException;
use App\Shared\Exceptions\FraudException;

class UserService
{
    private UserRepository $userRepository;
    private UserLogRepository $userLogRepository;
    private FraudChecker $fraudChecker;
    private Mailer $mailer;

    public function __construct(UserRepository $userRepository, UserLogRepository $userLogRepository, FraudChecker $fraudChecker, Mailer $mailer)
    {
        $this->userRepository = $userRepository;
        $this->userLogRepository = $userLogRepository;
        $this->fraudChecker = $fraudChecker;
        $this->mailer = $mailer;
    }

    public function registerUser(UserRegisterDto $data): array
    {
        $fraudCheck = $this -> fraudChecker->checkFraud($data->email, $data->ip);
        
        if($fraudCheck) {
           throw new FraudException('Fraud detected!');
        }
                
        if($this->userRepository -> findByEmail($data->email)) {
           throw new DuplicateException('Email already exists!');
        }
        
        $user = new User(
           null,
           $data->email,
           password_hash($data -> password, PASSWORD_BCRYPT)
        );
        
        $newUser = $this->userRepository ->create($user);
        
        $this->mailer->send($user->getEmail(), 'Dobro došli', 'Dobro došli na nas sajt. Potrebno je samo da potvrdite email adresu ...');
        
        $userLog = new UserLog(
           null,
           'register',
           null,
           $newUser->getId()
        );
        
        $this -> userLogRepository->create($userLog);
        
        session_start();
        $_SESSION['userId'] = $user->getId();
        
        return ['userId' => $newUser->getId()];
    }

}
