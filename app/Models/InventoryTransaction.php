<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'inventory_item_id', 'project_id', 'type',
        'quantity', 'reference', 'transaction_date', 'recorded_by', 'notes',
    ];

    protected function casts(): array
    {
        return ['quantity' => 'decimal:2', 'transaction_date' => 'date'];
    }

    protected static function booted()
    {
        static::created(function (InventoryTransaction $tx) {
            $delta = $tx->type === 'stock_out' ? -abs($tx->quantity) : abs($tx->quantity);
            $tx->item()->increment('quantity_on_hand', $delta);
        });
    }

    public function item() { return $this->belongsTo(InventoryItem::class, 'inventory_item_id'); }
    public function project() { return $this->belongsTo(Project::class); }
    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); }
}
