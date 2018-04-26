<?php

namespace app\repositories;

use app\models\User;
use DomainException;

class UserRepository {
    /**
     * @param $id
     * @return User
     * @throws DomainException
     */
    public function find($id)
    {
        if ( ! $user = User::findOne($id)) {
            throw new DomainException('Model not found.');
        }
        return $user;
    }

    public function findOrCreateByUsername($username)
    {
        $user = User::findOne(['username' => $username]);
        if( $user === null){
            $user = User::create($username);
            $this->add($user);
        }

        return $user;
    }

    public function add(User $user)
    {
        if ( ! $user->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if ( ! $user->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function edit(User $user)
    {
        if ($user->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($user->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}