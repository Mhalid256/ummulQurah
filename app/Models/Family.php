<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;

class Family extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'family_code', 'head_name', 'members_count',
        'address', 'location', 'income_level', 'status',
    ];

    public function beneficiaries() { return $this->hasMany(Beneficiary::class); }
}
