<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['adherent_id', 'coach_id', 'goal', 'progress', 'progress_date', 'notes'])]
class GoalProgress extends Model
{
    protected $table = 'goal_progress';

    public function adherent()
    {
        return $this->belongsTo(User::class, 'adherent_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
