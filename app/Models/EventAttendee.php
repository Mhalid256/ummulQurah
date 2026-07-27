<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'attendee_type', 'attendee_id', 'guest_name', 'attended'];

    protected function casts(): array
    {
        return ['attended' => 'boolean'];
    }

    public function event() { return $this->belongsTo(Event::class); }
}
