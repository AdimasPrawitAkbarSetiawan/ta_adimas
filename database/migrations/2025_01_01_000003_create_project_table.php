<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique(); // contoh: PRJ-2025-001
            $table->string('name');
            $table->text('description');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('marketing_id')->constrained('users')->onDelete('cascade');
            $table->decimal('budget_estimate', 15, 2)->nullable(); // anggaran awal dari marketing
            $table->decimal('budget_final', 15, 2)->nullable();    // anggaran final setelah revisi
            $table->enum('status', [
                'draft',        // marketing baru buat
                'review',       // sudah dikirim ke owner, menunggu tinjauan
                'revision',     // owner minta revisi
                'approved',     // owner setuju
                'in_progress',  // proyek sedang berjalan
                'completed',    // proyek selesai
                'rejected',     // owner tolak
            ])->default('draft');
            $table->date('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};