<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->writeAuditLog('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $model->writeAuditLog('updated', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model) {
            $model->writeAuditLog('deleted', $model->getAttributes(), null);
        });
    }

    protected function writeAuditLog(string $action, ?array $old, ?array $new): void
    {
        if (! auth()->check()) {
            return;
        }

        AuditLog::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => static::class,
            'auditable_id' => $this->getKey(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()?->ip(),
        ]);
    }
}
