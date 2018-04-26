<?php

namespace tests\models\forms;

use app\models\forms\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private $model;

    public function testFilledUsername()
    {
        $this->model = new LoginForm([
            'username' => $this->tester->getFaker()->userName,
            'rememberMe' => true,
        ]);

        $this->model->validate();

        verify($this->model->errors)->isEmpty();
    }

    public function testEmptyUsername()
    {
        $this->model = new LoginForm([
            'username' => '',
            'rememberMe' => true,
        ]);

        $this->model->validate();

        verify($this->model->errors)->hasKey('username');
    }

}
