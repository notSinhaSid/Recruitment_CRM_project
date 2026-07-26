<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void {
        static::creating(function($tenant) {
            if(empty($tenant->slug)){
                $tenant->slug = Str::slug($tenant->name);
            }
        });
    }

    public function users(): HasMany{
        return $this->hasMany(User::class);
    }
}
