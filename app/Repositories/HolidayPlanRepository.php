<?php

namespace App\Repositories;

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HolidayPlanRepository
{
    /**
     * @param User $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function listByUser(User $user, int $perPage = 10): LengthAwarePaginator
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

    /**
     * @param int $id
     * @return HolidayPlan
     * @throws ModelNotFoundException
     */
    public function findById(int $id): HolidayPlan
    {
        /** @var HolidayPlan $holidayPlan */
        $holidayPlan = HolidayPlan::query()->findOrFail($id);
        return $holidayPlan;
    }
}
