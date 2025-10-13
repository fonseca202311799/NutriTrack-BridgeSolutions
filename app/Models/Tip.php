<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\factories\HasFactory;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'created_by',
    ];

    // 🔗 Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
