<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HolidayPlanResource extends JsonResource
{
    public static $wrap = 'holiday_plan';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date->format('d/m/Y'),
            'location' => $this->location,
            'owner' => new UserResource($this->owner),
            'participants' => UserResource::collection($this->participants),
        ];
    }
}
