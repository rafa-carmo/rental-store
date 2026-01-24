<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    /** @use HasFactory<\Database\Factories\ItemTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orWhere('is_active', 'on');
    }
}
