<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'item_id',
        'value',
        'pickup_date',
        'return_date',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'pickup_date' => 'date',
            'return_date' => 'date',
            'returned_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
