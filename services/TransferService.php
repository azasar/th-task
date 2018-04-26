<?php

namespace app\services;


use app\exceptions\InsufficientBalanceException;
use app\models\Transfer;
use app\repositories\TransferRepository;
use app\repositories\UserRepository;

class TransferService
{
    private $users;
    private $transfers;
    private $transactionManager;

    public function __construct(
        UserRepository $userRepository,
        TransferRepository $transferRepository,
        TransactionManager $transactionManager
    )
    {
        $this->users = $userRepository;
        $this->transfers = $transferRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create($senderId, $recipientUsername, $amount)
    {
        $sender = $this->users->find($senderId);
        $recipient = $this->users->findOrCreateByUsername($recipientUsername);

        if ($sender->id === $recipient->id){
            throw new \DomainException("User can't transfer money to himself");
        }

        if ($sender->hasEnoughBalance($amount)) {
            $transfer = Transfer::create($sender->id, $recipient->id, $amount);
            $this->transactionManager->execute(function () use ($transfer) {
                $this->transfers->add($transfer);
            });
        } else {
            throw new InsufficientBalanceException('Not enough balance');
        }
    }
}