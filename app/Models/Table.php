<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number', 'uuid', 'qr_code_path', 'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get average table rating (1-5)
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings()->avg('table_rating') ?? 5.0, 1);
    }

    /**
     * Get total rating count for this table
     */
    public function getTotalRatingsCountAttribute(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Get total favorite votes
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->ratings()->where('is_favorite_table', true)->count();
    }
}
