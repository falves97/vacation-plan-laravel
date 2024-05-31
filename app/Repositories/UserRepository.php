<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findById(int $id): User
    {
        /** @var User $user */
        $user =  User::query()->findOrFail($id);
        return $user;
    }

    /**
     * @param string $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmail(string $email): User
    {
        /** @var User $user */
        $user =  User::query()->where('email', $email)->firstOrFail();
        return $user;
    }
}
