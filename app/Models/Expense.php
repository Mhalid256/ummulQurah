<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;

class Expense extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'budget_id', 'project_id', 'category', 'description',
        'amount', 'expense_date', 'vendor', 'receipt_path', 'status',
        'submitted_by', 'approved_by',
    ];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'expense_date' => 'date'];
    }

    protected static function booted()
    {
        static::updated(function (Expense $expense) {
            if ($expense->wasChanged('status') && $expense->status === 'approved' && $expense->budget_id) {
                $expense->budget()->increment('amount_spent', $expense->amount);
            }
        });
    }

    public function budget() { return $this->belongsTo(Budget::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function submittedBy() { return $this->belongsTo(User::class, 'submitted_by'); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
}
