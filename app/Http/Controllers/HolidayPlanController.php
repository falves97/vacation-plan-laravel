<?php

namespace App\Http\Controllers;

use App\Http\Resources\HolidayPlanResource;
use App\Models\HolidayPlan;
use App\Models\User;
use App\Repositories\HolidayPlanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayPlanController extends Controller
{
    public function __construct(private HolidayPlanRepository $holidayPlanRepository)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HolidayPlan $holidayPlan)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $perPage = intval($request->query('per_page'));
        $holidayPlans = $this->holidayPlanRepository->listByUser($user, $perPage);

        return HolidayPlanResource::collection($holidayPlans);
    }

    /**
     * Display the specified resource.
     */
    public function show(HolidayPlan $holidayPlan)
    {
        $this->authorize('view', $holidayPlan);

        return new HolidayPlanResource($holidayPlan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HolidayPlan $holidayPlan)
    {
        //
    }
}
