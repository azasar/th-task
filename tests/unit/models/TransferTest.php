<?php

namespace tests\models;

use app\models\Transfer;
use app\models\User;

class TransferTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var User
     */
    protected $user;

    public function testCreate()
    {
        $faker = $this->tester->getFaker();

        $sender = $this->tester->getFactory()->create(User::class, [
            'username' => $faker->name
        ]);
        $recipient = $this->tester->getFactory()->create(User::class, [
            'username' => $faker->name
        ]);

        $transfer = Transfer::create($sender->id, $recipient->id, $faker->numberBetween(1, 1000));

        verify($transfer)->isInstanceOf(Transfer::class);
    }
}
