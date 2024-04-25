<?php

namespace Tests\Unit;

use App\Models\HolidayPlan;
use App\Models\User;
use App\Services\HolidayPlanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUser(): void
    {
        $this->assertInstanceOf(User::class, User::factory()->create());
    }

    public function testGetUserHolidayPlans()
    {
        $user = User::factory()->create();
        $participants = User::factory()->count(2)->create();
        $holidayPlan = HolidayPlan::factory()->create();

        /** @var HolidayPlanService $holidayPlanService */
        $holidayPlanService = app()->make(HolidayPlanService::class);

        $this->actingAs($user);
        $holidayPlanService->syncHolidayPlanWithParticipants($holidayPlan, $participants);

        $this->assertInstanceOf(HolidayPlan::class, $user->holidayPlans->get(0));
        $this->assertCount(1, $user->holidayPlans);
    }
}
