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
            $changes = collect($model->getChanges())
                ->except(['updated_at', 'created_at'])
                ->all();

            if (empty($changes)) {
                return;
            }

            $model->writeAuditLog('updated', $changes);
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
