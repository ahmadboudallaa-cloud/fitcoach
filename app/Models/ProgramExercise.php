<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['training_program_id', 'name', 'sets', 'reps', 'notes'])]
class ProgramExercise extends Model
{
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class);
    }
}
