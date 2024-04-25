<?php

namespace App\Policies;

use App\Models\HolidayPlan;
use App\Models\User;

class HolidayPlanPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HolidayPlan $holidayPlan): bool
    {
        return true;
//        return $user->holidayPlans->contains($holidayPlan);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HolidayPlan $holidayPlan): bool
    {
        return true;
//        return $user->holidayPlans->contains($holidayPlan);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HolidayPlan $holidayPlan): bool
    {
        return true;
//        return $holidayPlan->owner->id === $user->id || $holidayPlan->participants->contains($user);
    }
}
