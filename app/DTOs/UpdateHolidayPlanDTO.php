<?php

namespace App\DTOs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class UpdateHolidayPlanDTO
{
    /**
     * @param string|null $title
     * @param string|null $description
     * @param string|null $location
     * @param Carbon|null $date
     * @param User|null $owner
     * @param Collection|null $participants
     */
    public function __construct(
        public readonly ?string     $title = null,
        public readonly ?string     $description = null,
        public readonly ?string     $location = null,
        public readonly ?Carbon     $date = null,
        public readonly ?User       $owner = null,
        public readonly ?Collection $participants = null,
    ) {
    }
}
