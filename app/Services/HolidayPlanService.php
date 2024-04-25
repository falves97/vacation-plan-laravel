<?php

namespace App\Services;

use App\Models\HolidayPlan;
use Illuminate\Support\Collection;

class HolidayPlanService
{
    public function syncHolidayPlanWithParticipants(HolidayPlan $holidayPlan, Collection $participants): HolidayPlan
    {
        $participantsId = $participants
            // Add owner as participant
            ->push($holidayPlan->owner)
            // Obtain only their ids
            ->pluck('id');

        $holidayPlan->participants()->sync($participantsId);

        return $holidayPlan;
    }
}
