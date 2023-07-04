<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_name',
        'description',
        'image',
        'category',
        'price',
        'VAT',
        'status',
    ];

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'recipe_inventory', 'recipe_id', 'inventory_id')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function wastes()
    {
        return $this->hasMany(Waste::class);
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }
}
