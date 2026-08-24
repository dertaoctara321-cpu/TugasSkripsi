<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const WAITERS = [
        'RADHO (PART TIME)',
        'YUDHA KURNIAWAN',
        'SYAUKI',
        'M.RIDHO',
        'M. FAHRI SARMAN',
        'SITI AISYAH',
        'DEWI',
        'FAREL',
        'FUAD',
        'DERTA'
    ];

    protected $fillable = [
        'table_id', 'total_amount', 'payment_method', 'payment_status', 'order_status', 'customer_name', 'waiter_name', 'floor'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}
