<?php

namespace app\services;


use app\models\forms\LoginForm;
use app\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function auth(LoginForm $form)
    {
        $user = $this->users->findOrCreateByUsername($form->username);
        if ( ! $user) {
            throw new \DomainException('Undefined user');
        }
        return $user;
    }
}