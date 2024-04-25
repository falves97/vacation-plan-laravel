<?php

namespace App\Repositories;

use App\Models\User;

class HolidayPlanRepository
{
    public function listByUser(User $user, int $perPage = 10)
    {
        $perPage = $perPage <= 0 ? 10 : $perPage;

        return $user
            ->holidayPlans()
            ->paginate($perPage, [
                'id',
                'title',
                'description',
                'location',
                'owner_id',
                'date',
            ])->appends('per_page', $perPage);
    }
}
