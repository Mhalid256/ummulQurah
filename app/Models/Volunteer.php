<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'project_id', 'volunteer_no', 'first_name', 'last_name',
        'email', 'phone', 'skills', 'availability', 'status', 'coordinator_id', 'notes',
    ];

    public function project() { return $this->belongsTo(Project::class); }
    public function coordinator() { return $this->belongsTo(User::class, 'coordinator_id'); }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
