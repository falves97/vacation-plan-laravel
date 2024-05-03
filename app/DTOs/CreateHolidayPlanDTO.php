<?php

namespace App\DTOs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class CreateHolidayPlanDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string $location
     * @param Carbon $date
     * @param User $owner
     * @param Collection<User> $participants
     */
    public function __construct(
        public readonly string     $title,
        public readonly string     $description,
        public readonly string     $location,
        public readonly Carbon     $date,
        public readonly User       $owner,
        public readonly Collection $participants,
    ) {
    }
}
