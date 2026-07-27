<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'project_id', 'title', 'slug', 'category', 'summary',
        'description', 'cover_image', 'goal_amount', 'raised_amount', 'currency',
        'start_date', 'end_date', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'goal_amount' => 'decimal:2',
            'raised_amount' => 'decimal:2',
        ];
    }

    protected static function booted()
    {
        static::creating(function (Campaign $campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->title) . '-' . Str::random(5);
            }
        });
    }

    public function project() { return $this->belongsTo(Project::class); }
    public function donations() { return $this->hasMany(Donation::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    public function getProgressPercentAttribute(): int
    {
        if ((float) $this->goal_amount <= 0) return 0;
        return (int) min(100, round(((float) $this->raised_amount / (float) $this->goal_amount) * 100));
    }
}
