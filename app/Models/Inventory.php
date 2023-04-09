<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'available_units',
        'unit_cost',
        'measurement_unit',
        'last_added'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_inventory', 'inventory_id', 'recipe_id');
    }
}
