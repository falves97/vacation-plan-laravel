<?php

use App\Models\HolidayPlan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holiday_plans_participants', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'participant_id');
            $table->foreignIdFor(HolidayPlan::class, 'holiday_plan_id');
            $table->timestamps();
            $table->index(['participant_id', 'holiday_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_plans_participants');
    }
};
