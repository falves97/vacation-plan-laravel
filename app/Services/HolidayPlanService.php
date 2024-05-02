<?php

namespace App\Services;

use App\Models\HolidayPlan;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    /**
     * @param Collection $emails
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function makeParticipantsCollectionByEmail(Collection $emails): Collection
    {
        $participantsCollection = collect();
        foreach ($emails as $email) {
            $participant = $this->userRepository->findByEmail($email);
            $participantsCollection->push($participant);
        }

        return $participantsCollection;
    }
}
