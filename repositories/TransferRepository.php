<?php

namespace app\repositories;

use app\models\Transfer;
use DomainException;

class TransferRepository {
    /**
     * @param $id
     * @return Transfer
     * @throws DomainException
     */
    public function find($id)
    {
        if ( ! $transfer = Transfer::findOne($id)) {
            throw new DomainException('Model not found.');
        }
        return $transfer;
    }

    public function add(Transfer $transfer)
    {
        if ( ! $transfer->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if ( ! $transfer->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function edit(Transfer $transfer)
    {
        if ($transfer->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($transfer->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(Transfer $transfer)
    {
        if (!$transfer->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}