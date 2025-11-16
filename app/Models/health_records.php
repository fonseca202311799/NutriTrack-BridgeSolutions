<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\students;

class health_records extends Model
{

    use HasFactory;

    protected $fillable = [
        'student_id',
        'height',
        'weight',
        'bmi',
        'status',
        'calories',
        'protein',
        'carbs',
        'fat',
        'recorded_at',
    ];

    protected $dates = ['recorded_at'];

    // 🔗 Relationships
    public function student()
    {
        // Explicit foreign key to match migration column `student_id`
        return $this->belongsTo(students::class, 'student_id');
    }


}
