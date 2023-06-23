<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'amount',
        'recipe_name',
        'production_cost',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
