<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'sku', 'name', 'category', 'unit',
        'quantity_on_hand', 'reorder_level', 'unit_cost', 'warehouse', 'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'decimal:2',
            'reorder_level' => 'decimal:2',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function transactions() { return $this->hasMany(InventoryTransaction::class); }

    public function getIsLowStockAttribute(): bool
    {
        return (float) $this->quantity_on_hand <= (float) $this->reorder_level;
    }
}
