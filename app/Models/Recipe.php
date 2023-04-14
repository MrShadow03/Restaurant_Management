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
        return $this->belongsToMany(Inventory::class, 'recipe_inventory', 'recipe_id', 'inventory_id')->withPivot('amount');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()->count();
    }
}
