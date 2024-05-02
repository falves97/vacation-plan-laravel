<?php

namespace App\Repositories;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * @param $email
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByEmail($email): User
    {
        /** @var User $user */
        $user =  User::query()->where('email', $email)->first();
        return $user;
    }
}
