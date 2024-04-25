<?php

namespace Database\Seeders;

use App\Models\HolidayPlan;
use App\Models\User;
use App\Services\HolidayPlanService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidayPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HolidayPlan::truncate();
        DB::table('holiday_plans_participants')->truncate();

        User::all()->each(function (User $user) {
            HolidayPlan::factory()
//                ->count(3)
                ->create([
                    'owner_id' => $user->id,
                ]);
        });

        HolidayPlan::all()->each(function (HolidayPlan $holidayPlan) {
            $holidayPlanService = new HolidayPlanService();

            $randomUsers = User::all()->random(2);
            $holidayPlanService->syncHolidayPlanWithParticipants($holidayPlan, $randomUsers);
        });
    }
}
