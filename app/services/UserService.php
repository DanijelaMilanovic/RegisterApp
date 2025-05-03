<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\User;
use App\Domain\UserLog;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserLogRepository;

use App\Services\Dtos\UserRegisterDto;
use App\Presentation\Http\JsonResponse; //TODO: refactor this 

class UserService
{
    private UserRepository $userRepository;
    private UserLogRepository $userLogRepository;
    private FraudCheckerStrategy $fraudCheckerStrategy;

    public function __construct(UserRepository $userRepository, UserLogRepository $userLogRepository, FraudCheckerStrategy $fraudCheckerStrategy)
    {
        $this->userRepository = $userRepository;
        $this->userLogRepository = $userLogRepository;
        $this->fraudCheckerStrategy = $fraudCheckerStrategy;
    }

    public function registerUser(UserRegisterDto $data): void
    {
        $fraudCheck = $this -> fraudCheckerStrategy->checkFraud($data->email, $data->ip);
        
        if($fraudCheck) {
           JsonResponse::forbidden('Request denied!');
        }
                
        if($this->userRepository -> findByEmail($data->email)) {
           JsonResponse::badRequest('Email already exists!');
        }
        
        $user = new User(
           null,
           $data->email,
           password_hash($data -> password, PASSWORD_BCRYPT)
        );
        
        $newUser = $this->userRepository ->create($user);
        
        mail($user->getEmail(), 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...', 'adm@kupujemprodajem.com');
        
        $userLog = new UserLog(
           null,
           'register',
           null,
           $newUser->getId()
        );
        
        $this -> userLogRepository->create($userLog);
        
        $_SESSION['userId'] = $user->getId();
        
        JsonResponse::ok(['userId' => $newUser->getId()]);
    }
}
