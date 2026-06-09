<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['adherent_id', 'coach_id', 'session_date', 'start_time', 'end_time', 'status', 'notes'])]
class CoachingSession extends Model
{
    public function adherent()
    {
        return $this->belongsTo(User::class, 'adherent_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
