<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function inventories(){
        return $this->hasManyThrough(Inventory::class, Recipe::class, 'id', 'id', 'recipe_id', 'inventory_id');
    }
}
