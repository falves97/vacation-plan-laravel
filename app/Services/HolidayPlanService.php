<?php

namespace App\Services;

use App\DTOs\HolidayPlanDTO;
use App\Models\HolidayPlan;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class HolidayPlanService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public static function createHolidayPlan(HolidayPlanDTO $holidayPlanDto): HolidayPlan
    {
        /** @var HolidayPlan $holidayPlan */
        $holidayPlan =  HolidayPlan::query()->create([
            'title' => $holidayPlanDto->title,
            'description' => $holidayPlanDto->description,
            'date' => $holidayPlanDto->date,
            'location' => $holidayPlanDto->location,
            'owner_id' => $holidayPlanDto->owner->id,
        ]);

        return $holidayPlan;
    }

    /**
     * @param HolidayPlan $holidayPlan
     * @param Collection $participants
     * @return HolidayPlan
     */
    public static function syncHolidayPlanWithParticipants(HolidayPlan $holidayPlan, Collection $participants): HolidayPlan
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
