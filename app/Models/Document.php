<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id', 'title', 'category', 'file_path', 'file_type',
        'file_size', 'documentable_type', 'documentable_id', 'uploaded_by',
    ];

    public function uploadedBy() { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function documentable() { return $this->morphTo(); }
}
