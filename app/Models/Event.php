<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'project_id', 'title', 'type', 'description',
        'location', 'start_at', 'end_at', 'status', 'organizer_id',
    ];

    protected function casts(): array
    {
        return ['start_at' => 'datetime', 'end_at' => 'datetime'];
    }

    public function project() { return $this->belongsTo(Project::class); }
    public function organizer() { return $this->belongsTo(User::class, 'organizer_id'); }
    public function attendees() { return $this->hasMany(EventAttendee::class); }
}
