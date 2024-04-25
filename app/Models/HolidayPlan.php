<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property integer $owner_id
 * @property User $owner
 * @property Collection<User> $participants
 */
class HolidayPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'owner_id',
    ];

    protected $casts = [
        'date' => 'date:d/m/Y',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'holiday_plans_participants',
            'holiday_plan_id',
            'participant_id'
        );
    }
}
