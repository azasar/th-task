<?php

namespace tests\models\forms;

use app\models\forms\TransferForm;
use app\models\User;

class TransferFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var User
     */
    private $user;

    public function testCorrectFilledForm()
    {
        $model = new TransferForm($this->user, [
            'recipientUsername' => $this->tester->getFaker()->userName,
            'amount' => $this->tester->getFaker()->numberBetween(1, 100)
        ]);

        $model->validate();

        verify($model->errors)->isEmpty();
    }

    public function testTransferToYourself()
    {
        $model = new TransferForm($this->user, [
            'recipientUsername' => $this->user->username,
            'amount' => $this->tester->getFaker()->numberBetween(1, 100)
        ]);

        $model->validate();

        verify($model->errors)->hasKey('recipientUsername');
    }

    public function testNotEnoughBalance()
    {
        $model = new TransferForm($this->user, [
            'recipientUsername' => $this->tester->getFaker()->userName,
            'amount' => $this->tester->getFaker()->numberBetween(10000, 100000)
        ]);

        $model->validate();

        verify($model->errors)->hasKey('amount');
    }

    public function testWrongAmount()
    {
        $this->tester->amGoingTo('Test with 3 digits after precision');
        $model = new TransferForm($this->user, [
            'recipientUsername' => $this->tester->getFaker()->userName,
            'amount' => 10.234
        ]);
        $model->validate();
        verify($model->errors)->hasKey('amount');

        $this->tester->amGoingTo('Test with word');
        $model->amount = $this->tester->getFaker()->userName;
        $model->validate();
        verify($model->errors)->hasKey('amount');

        $this->tester->amGoingTo('Test with negative amount');
        $model->amount = -10;
        $model->validate();
        verify($model->errors)->hasKey('amount');
    }

    protected function _before()
    {
        $this->user = $this->tester->getFactory()->create(User::class, [
            'username' => $this->tester->getFaker()->userName
        ]);
    }

}
