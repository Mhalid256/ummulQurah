<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Budget extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'project_id', 'title', 'category',
        'amount_allocated', 'amount_spent', 'fiscal_year', 'status',
    ];

    protected function casts(): array
    {
        return ['amount_allocated' => 'decimal:2', 'amount_spent' => 'decimal:2'];
    }

    public function project() { return $this->belongsTo(Project::class); }
    public function expenses() { return $this->hasMany(Expense::class); }

    public function getRemainingAttribute(): float
    {
        return (float) $this->amount_allocated - (float) $this->amount_spent;
    }
}
