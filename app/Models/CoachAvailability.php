<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['coach_id', 'available_date', 'start_time', 'end_time', 'is_available'])]
class CoachAvailability extends Model
{
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
