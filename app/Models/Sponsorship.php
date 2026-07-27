<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;

class Sponsorship extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'sponsor_id', 'beneficiary_id', 'amount', 'currency',
        'frequency', 'start_date', 'end_date', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'start_date' => 'date', 'end_date' => 'date'];
    }

    public function sponsor() { return $this->belongsTo(Donor::class, 'sponsor_id'); }
    public function beneficiary() { return $this->belongsTo(Beneficiary::class); }
}
