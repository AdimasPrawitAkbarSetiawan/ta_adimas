<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rincian teknis yang diisi oleh tim operasional setelah proyek disetujui
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->unique()->constrained('projects')->onDelete('cascade');
            $table->foreignId('operational_id')->constrained('users')->onDelete('cascade');
            $table->text('scope_of_work');       // rincian lingkup pekerjaan
            $table->text('tools_materials')->nullable(); // alat dan bahan
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes')->nullable();   // catatan tambahan dari operasional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};