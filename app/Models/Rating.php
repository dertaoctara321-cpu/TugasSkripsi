<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'table_id',
        'customer_name',
        'waiter_name',
        'food_rating',
        'table_rating',
        'waiter_rating',
        'is_favorite_table',
        'review',
        'waiter_review',
    ];

    protected $casts = [
        'food_rating' => 'integer',
        'table_rating' => 'integer',
        'waiter_rating' => 'integer',
        'is_favorite_table' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
