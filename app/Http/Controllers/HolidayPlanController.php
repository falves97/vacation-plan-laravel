<?php

namespace App\Http\Controllers;

use App\Http\Resources\HolidayPlanResource;
use App\Models\HolidayPlan;
use App\Models\User;
use App\Repositories\HolidayPlanRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HolidayPlanController extends Controller
{
    public function __construct(private readonly HolidayPlanRepository $holidayPlanRepository)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $holidayPlan = $this->holidayPlanRepository->findById($id);
            $this->authorize('delete', $holidayPlan);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $holidayPlan->delete();

        return response()->json(status: Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request): AnonymousResourceCollection
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
    public function show(int $id): HolidayPlanResource|JsonResponse
    {
        try {
            $holidayPlan = $this->holidayPlanRepository->findById($id);
            $this->authorize('view', $holidayPlan);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

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
