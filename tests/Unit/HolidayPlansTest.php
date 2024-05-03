<?php

namespace Tests\Unit;

use App\Models\HolidayPlan;
use App\Models\User;
use App\Services\HolidayPlanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HolidayPlansTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateHoliday(): void
    {
        /** @var HolidayPlan $holidayPlan */
        $holidayPlan = HolidayPlan::factory()->create();
        $this->assertInstanceOf(HolidayPlan::class, $holidayPlan);
    }

    public function testCreateHolidayWithParticipants()
    {
        $user = User::factory()->create();
        $participants = User::factory()->count(2)->create();
        $holidayPlan = HolidayPlan::factory()->create();

        /** @var HolidayPlanService $holidayPlanService */
        $holidayPlanService = app()->make(HolidayPlanService::class);

        $this->actingAs($user);
        $holidayPlanService->syncHolidayPlanWithParticipants($holidayPlan, $participants);

        $this->assertInstanceOf(User::class, $holidayPlan->participants->get(0));
        $this->assertCount(3, $holidayPlan->participants);
    }
}
