<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'registration_no', 'email', 'phone',
        'address', 'logo', 'country', 'currency', 'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
