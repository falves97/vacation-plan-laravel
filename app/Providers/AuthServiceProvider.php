<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\HolidayPlan;
use App\Policies\HolidayPlanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        HolidayPlan::class => HolidayPlanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Passport::hashClientSecrets();
        Passport::personalAccessTokensExpireIn(now()->addMonth());
    }
}
