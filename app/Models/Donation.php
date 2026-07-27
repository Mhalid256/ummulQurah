<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\Auditable;
use Illuminate\Support\Str;

class Donation extends Model
{
    use HasFactory, BelongsToOrganization, Auditable;

    protected $fillable = [
        'organization_id', 'donor_id', 'campaign_id', 'receipt_no', 'amount', 'currency',
        'payment_method', 'transaction_ref', 'status', 'donation_date', 'received_by', 'notes',
    ];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'donation_date' => 'date'];
    }

    protected static function booted()
    {
        static::creating(function (Donation $donation) {
            if (empty($donation->receipt_no)) {
                $donation->receipt_no = 'RCT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });

        static::created(function (Donation $donation) {
            $donation->applyToTotals();
        });
    }

    public function applyToTotals(): void
    {
        if ($this->status !== 'completed') {
            return;
        }

        $this->donor()->increment('total_donated', $this->amount);

        if ($this->campaign_id) {
            $this->campaign()->increment('raised_amount', $this->amount);
        }
    }

    public function donor() { return $this->belongsTo(Donor::class); }
    public function campaign() { return $this->belongsTo(Campaign::class); }
    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }
}
