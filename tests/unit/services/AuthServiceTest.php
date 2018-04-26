<?php

namespace tests\services;

use app\models\forms\LoginForm;
use app\models\User;
use app\services\AuthService;

class AuthServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var AuthService
     */
    private $service;

    public function testAuth()
    {
        $form = new LoginForm([
            'username' => $this->tester->getFaker()->userName,
            'rememberMe' => true
        ]);
        $user = $this->service->auth($form);

        verify($user->username)->equals($form->username);
        verify($user)->isInstanceOf(User::class);
    }

    protected function _before()
    {
        $this->service = \Yii::createObject(AuthService::class);
    }

}