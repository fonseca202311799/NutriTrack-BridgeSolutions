<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaterIntake extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount_ml',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }
}
