<?php

namespace App\Http\Controllers;

use App\DTOs\CreateHolidayPlanDTO;
use App\DTOs\UpdateHolidayPlanDTO;
use App\Http\Requests\StoreHolidayPlanRequest;
use App\Http\Requests\UpdateHolidayPlanRequest;
use App\Http\Resources\HolidayPlanCollection;
use App\Http\Resources\HolidayPlanResource;
use App\Models\User;
use App\Repositories\HolidayPlanRepository;
use App\Services\HolidayPlanService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HolidayPlanController extends Controller
{
    public function __construct(
        private readonly HolidayPlanRepository $holidayPlanRepository,
        private readonly HolidayPlanService $holidayPlanService
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request): HolidayPlanCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $perPage = intval($request->query('per_page'));
        $holidayPlans = $this->holidayPlanRepository->listByUser($user, $perPage);

        return new HolidayPlanCollection($holidayPlans);
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
    public function store(StoreHolidayPlanRequest $request): HolidayPlanResource
    {
        $holidayPlanData = $request->validated();

        $participants = collect();
        if (!empty($holidayPlanData['participants'])) {
            $participants = $this->holidayPlanService->makeParticipantsCollectionById(collect($holidayPlanData['participants']));
        }

        /** @var User $owner */
        $owner = Auth::user();
        $holidayPlanDto = new CreateHolidayPlanDTO(
            title: $holidayPlanData['title'],
            description: $holidayPlanData['description'],
            location: $holidayPlanData['location'],
            date: Carbon::createFromFormat('d/m/Y', $holidayPlanData['date']),
            owner: $owner,
            participants: $participants,
        );

        $holidayPlan = HolidayPlanService::createHolidayPlan($holidayPlanDto);

        return new HolidayPlanResource($holidayPlan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayPlanRequest $request, int $id): HolidayPlanResource|JsonResponse
    {
        $holidayPlanData = $request->validated();

        try {
            $holidayPlan = $this->holidayPlanRepository->findById($id);
            $this->authorize('update', $holidayPlan);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $participants = null;
        if (!empty($holidayPlanData['participants'])) {
            $participants = $this->holidayPlanService->makeParticipantsCollectionById(collect($holidayPlanData['participants']));
        }

        $holidayPlanDto = new UpdateHolidayPlanDTO(
            title: $holidayPlanData['title'] ?? null,
            description: $holidayPlanData['description'] ?? null,
            location: $holidayPlanData['location'] ?? null,
            date: isset($holidayPlanData['date']) ? Carbon::createFromFormat('d/m/Y', $holidayPlanData['date']) : null,
            participants: $participants,
        );

        $holidayPlan = HolidayPlanService::updateHolidayPlan($holidayPlanDto, $holidayPlan);

        return new HolidayPlanResource($holidayPlan);
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

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
