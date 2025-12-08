<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\students;

class goals extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'goal_type',
        'target',
        'is_completed',
        'target_value',
        'target_unit',
        'current_value',
        'due_date',
    ];

    // 🔗 Relationships
    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    public function progress()
    {
        return $this->hasMany(GoalProgress::class, 'goal_id');
    }

    public function percentage(): int
    {
        if ($this->target_value && $this->target_value > 0) {
            return (int) min(100, round(($this->current_value / $this->target_value) * 100));
        }
        return 0;
    }
}
