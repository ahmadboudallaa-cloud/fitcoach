<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'specialty', 'phone', 'bio', 'is_active'])]
class CoachProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
