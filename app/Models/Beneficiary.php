<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;

class Beneficiary extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'family_id', 'project_id', 'beneficiary_no', 'first_name', 'last_name',
        'dob', 'gender', 'category', 'phone', 'address', 'location',
        'guardian_name', 'guardian_phone', 'status', 'registered_by',
        'approved_by', 'approved_at', 'notes',
    ];

    protected function casts(): array
    {
        return ['dob' => 'date', 'approved_at' => 'datetime'];
    }

    public function family() { return $this->belongsTo(Family::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function registeredBy() { return $this->belongsTo(User::class, 'registered_by'); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
    public function sponsorships() { return $this->hasMany(Sponsorship::class); }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function approve(User $approver): void
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);
    }
}
