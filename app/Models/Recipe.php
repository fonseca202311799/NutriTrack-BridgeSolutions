<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description','meal_type','calories','protein','carbs','fat','tags',
        'is_vegetarian','is_vegan','is_gluten_free','is_diabetic_friendly'
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
