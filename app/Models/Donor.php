<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;

class Donor extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'user_id', 'donor_no', 'type', 'first_name', 'last_name',
        'organization_name', 'email', 'phone', 'address', 'country',
        'is_recurring', 'total_donated', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['is_recurring' => 'boolean', 'total_donated' => 'decimal:2'];
    }

    public function donations() { return $this->hasMany(Donation::class); }
    public function sponsorships() { return $this->hasMany(Sponsorship::class, 'sponsor_id'); }

    public function getDisplayNameAttribute(): string
    {
        return $this->type === 'organization'
            ? (string) $this->organization_name
            : trim("{$this->first_name} {$this->last_name}");
    }
}
