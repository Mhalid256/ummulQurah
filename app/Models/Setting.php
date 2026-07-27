<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['organization_id', 'key', 'value'];

    public static function getFor(?int $organizationId, string $key, $default = null)
    {
        $setting = static::where('organization_id', $organizationId)->where('key', $key)->first();
        return $setting?->value ?? $default;
    }

    public static function setFor(?int $organizationId, string $key, $value): void
    {
        static::updateOrCreate(
            ['organization_id' => $organizationId, 'key' => $key],
            ['value' => $value]
        );
    }
}
