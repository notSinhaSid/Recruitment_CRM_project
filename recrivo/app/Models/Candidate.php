<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'linkedin_url',
        'years_of_experience',
        'source',
        'notes',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function applications(): HasMany {
        return $this->hasMany(Application::class);
    }
}