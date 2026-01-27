<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'item_type_id',
        'quantity_total',
        'quantity_available',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'quantity_total' => 'integer',
            'quantity_available' => 'integer',
        ];
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * Check if item has available quantity
     */
    public function hasAvailableQuantity(): bool
    {
        return $this->quantity_available > 0;
    }

    /**
     * Decrease available quantity (rent item)
     */
    public function decreaseQuantity(): void
    {
        if ($this->quantity_available > 0) {
            $this->quantity_available--;

            if ($this->quantity_available === 0) {
                $this->status = 'alugado';
            }

            $this->save();
        }
    }

    /**
     * Increase available quantity (return item)
     */
    public function increaseQuantity(): void
    {
        if ($this->quantity_available < $this->quantity_total) {
            $this->quantity_available++;

            if ($this->quantity_available > 0 && $this->status === 'alugado') {
                $this->status = 'disponivel';
            }

            $this->save();
        }
    }
}
