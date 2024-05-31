<?php

namespace App\Services;

use App\DTOs\CreateHolidayPlanDTO;
use App\DTOs\UpdateHolidayPlanDTO;
use App\Models\HolidayPlan;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class HolidayPlanService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public static function createHolidayPlan(CreateHolidayPlanDTO $holidayPlanDto): HolidayPlan
    {
        /** @var HolidayPlan $holidayPlan */
        $holidayPlan =  HolidayPlan::query()->create([
            'title' => $holidayPlanDto->title,
            'description' => $holidayPlanDto->description,
            'date' => $holidayPlanDto->date,
            'location' => $holidayPlanDto->location,
            'owner_id' => $holidayPlanDto->owner->id,
        ]);

        self::syncHolidayPlanWithParticipants($holidayPlan, $holidayPlanDto->participants);

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

    public static function updateHolidayPlan(UpdateHolidayPlanDTO $holidayPlanDto, HolidayPlan $holidayPlan): HolidayPlan
    {
        $holidayPlanData = (array) $holidayPlanDto;
        $holidayPlanData = array_filter($holidayPlanData);

        $holidayPlan->update(Arr::except($holidayPlanData, ['participants']));

        if ($holidayPlanDto->participants) {
            self::syncHolidayPlanWithParticipants($holidayPlan, $holidayPlanDto->participants);
        }

        return $holidayPlan;
    }

    /**
     * @param Collection<string> $emails
     * @return Collection<User>
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

    /**
     * @param Collection<integer> $ids
     * @return Collection<User>
     * @throws ModelNotFoundException
     */
    public function makeParticipantsCollectionById(Collection $ids): Collection
    {
        $participantsCollection = collect();
        foreach ($ids as $id) {
            $participant = $this->userRepository->findById($id);
            $participantsCollection->push($participant);
        }

        return $participantsCollection;
    }
}
