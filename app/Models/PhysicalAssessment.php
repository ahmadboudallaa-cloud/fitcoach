<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['adherent_id', 'coach_id', 'assessment_date', 'weight', 'height', 'body_fat', 'notes'])]
class PhysicalAssessment extends Model
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
