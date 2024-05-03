<?php

namespace Database\Seeders;

use App\Models\HolidayPlan;
use App\Models\User;
use App\Services\HolidayPlanService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidayPlanSeeder extends Seeder
{
    public function __construct(private readonly HolidayPlanService $holidayPlanService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HolidayPlan::truncate();
        DB::table('holiday_plans_participants')->truncate();

        User::all()->each(function (User $user) {
            HolidayPlan::factory()
                ->count(3)
                ->create([
                    'owner_id' => $user->id,
                ]);
        });

        HolidayPlan::all()->each(function (HolidayPlan $holidayPlan) {
            $randomUsers = User::all()->random(2);
            $this->holidayPlanService->syncHolidayPlanWithParticipants($holidayPlan, $randomUsers);
        });
    }
}
