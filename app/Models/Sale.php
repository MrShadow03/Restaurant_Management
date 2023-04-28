<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'recipe_id',
        'recipe_name',
        'price',
        'quantity',
        'username',
        'table_number',
        'production_cost',
        'discount',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }
}
