<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_posting_id')->constrained()->cascadeOnDelete();
            $table->string('stage')->default('applied');
            $table->date('applied_at')->nullable();
            $table->timestamps();

            $table->unique(['candidate_id', 'job_posting_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};