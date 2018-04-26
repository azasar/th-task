<?php

namespace tests\services;

use app\models\Transfer;
use app\models\User;
use app\services\TransferService;

class TransferServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var User
     */
    private $user;

    /**
     * @var TransferServiceTest
     */
    private $service;

    public function testCreate()
    {

        $recipientUsername = $this->tester->getFaker()->userName;
        $amount = $this->tester->getFaker()->numberBetween(1, 1000);
        $this->service->create(
            $this->user->id,
            $recipientUsername,
            $amount
        );

        $this->tester->canSeeRecord(Transfer::class, [
            'sender_id' => $this->user->id,
            'amount' => $amount
        ]);
    }

    public function testCreateToYourself()
    {
        $this->tester->expectException(\DomainException::class, function (){
            $amount = $this->tester->getFaker()->numberBetween(1, 1000);
            $this->service->create(
                $this->user->id,
                $this->user->username,
                $amount
            );
        });
    }

    public function testCreateNotEnoughBalance()
    {
        $this->tester->expectException(\DomainException::class, function (){
            $amount = $this->tester->getFaker()->numberBetween(10000, 100000);
            $this->service->create(
                $this->user->id,
                $this->tester->getFaker()->userName,
                $amount
            );
        });
    }

    protected function _before()
    {
        $this->service = \Yii::createObject(TransferService::class);
        $this->user = $this->tester->getFactory()->create(User::class, [
            'username' => $this->tester->getFaker()->userName
        ]);
    }
}