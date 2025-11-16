<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\health_records;
use App\Models\goals;


class students extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'age',
        'sex',
        'grade_level',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthRecords()
    {
        // Explicit foreign key on related model table `health_records.student_id`
        return $this->hasMany(health_records::class, 'student_id');
    }

    public function goals()
    {
        return $this->hasMany(goals::class, 'student_id');
    }
}
