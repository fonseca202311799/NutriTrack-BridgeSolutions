<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\students;

class goals extends Model
{
     use HasFactory;

    protected $fillable = [
        'student_id',
        'goal_type',
        'target',
        'is_completed',
    ];

    // 🔗 Relationships
    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }
}
