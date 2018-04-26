<?php

namespace tests\models;

use app\models\Transfer;
use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var User
     */
    protected $user;

    public function testFindUserById()
    {
        expect_that($this->user = User::findIdentity($this->user->id));

        expect_not(User::findIdentity(99999));
    }

    public function testGetBalance(){
        $amount = $this->tester->getFaker()->numberBetween(1, 999);

        $transfer = $this->tester->getFactory()->create(Transfer::class, [
            'recipient_id' => $this->user->id,
            'amount' => $amount
        ]);

        verify($this->user->getBalance())->equals(true);
    }

    public function testBalance()
    {
        verify($this->user->hasEnoughBalance(User::CREDIT_LIMIT * -1))->equals(true);
        verify($this->user->hasEnoughBalance(User::CREDIT_LIMIT * -1 + 1))->equals(false);
    }

    public function testGetAvailableBalanceForTransfer()
    {
        verify($this->user->getAvailableBalanceForTransfer())->equals(User::CREDIT_LIMIT * -1);
    }

    protected function _before()
    {
        $this->user = $this->tester->getFactory()->create(User::class, [
            'username' => $this->tester->getFaker()->userName
        ]);
    }

}
