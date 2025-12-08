<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\health_records;
use App\Models\goals;
use App\Models\WaterIntake;
use App\Models\Exercise;
use Carbon\Carbon;


class students extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'age',
        'birth_date',
        'sex',
        'grade_level',
        'dietary_preferences',
        'allergies',
        'conditions',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthRecords()
    {
        return $this->hasMany(health_records::class, 'student_id');
    }

    public function goals()
    {
        return $this->hasMany(goals::class, 'student_id');
    }

    public function waterIntakes()
    {
        return $this->hasMany(WaterIntake::class, 'student_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'student_id');
    }

    public function getAgeAttribute()
    {
        if ($this->birth_date instanceof \Illuminate\Support\Carbon) {
            $dob = $this->birth_date;
        } elseif ($this->birth_date) {
            try {
                $dob = Carbon::parse($this->birth_date);
            } catch (\Throwable $e) {
                return null;
            }
        } else {
            return null;
        }

        $today = Carbon::today();
        return $dob->diffInYears($today);
    }
}
