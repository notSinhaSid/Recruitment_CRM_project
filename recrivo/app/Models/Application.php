<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\Auditable;

class Application extends Model
{
    use Auditable;
    protected $fillable = [
        'tenant_id',
        'candidate_id',
        'job_posting_id',
        'stage',
        'previous_stage',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }
}