<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Project extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'name', 'description', 'sector', 'manager_id',
        'budget_amount', 'start_date', 'end_date', 'status',
    ];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date'];
    }

    public function manager() { return $this->belongsTo(User::class, 'manager_id'); }
    public function campaigns() { return $this->hasMany(Campaign::class); }
    public function beneficiaries() { return $this->hasMany(Beneficiary::class); }
    public function budgets() { return $this->hasMany(Budget::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function grants() { return $this->hasMany(Grant::class); }
}
