<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'username',
        'customer_name',
        'customer_contact',
        'table_number',
        'paid',
        'discount',
        'total',
        'creator_name',
    ];

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
