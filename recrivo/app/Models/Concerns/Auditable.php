<?php

namespace App\Models\Concerns;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $model->writeAuditLog('created', $model->getAttributes());
        });

        static::updated(function ($model) {
            $model->writeAuditLog('updated', $model->getChanges());
        });

        static::deleted(function ($model) {
            $model->writeAuditLog('deleted', null);
        });
    }

    protected function writeAuditLog(string $action, ?array $changes): void
    {
        AuditLog::create([
            'tenant_id' => $this->tenant_id,
            'user_id' => auth()->id(),
            'auditable_type' => static::class,
            'auditable_id' => $this->getKey(),
            'action' => $action,
            'changes' => $changes,
        ]);
    }
}