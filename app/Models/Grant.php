<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;

class Grant extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'project_id', 'funder_name', 'title', 'amount', 'currency',
        'start_date', 'end_date', 'status', 'reporting_due_date', 'contact_person', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'reporting_due_date' => 'date',
        ];
    }

    public function project() { return $this->belongsTo(Project::class); }
}
