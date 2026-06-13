<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['adherent_id', 'coach_id', 'title', 'description', 'start_date', 'end_date'])]
class TrainingProgram extends Model
{
    public function adherent()
    {
        return $this->belongsTo(User::class, 'adherent_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function exercises()
    {
        return $this->hasMany(ProgramExercise::class);
    }
}
