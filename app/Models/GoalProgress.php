<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoalProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'value',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function goal()
    {
        return $this->belongsTo(goals::class, 'goal_id');
    }
}
