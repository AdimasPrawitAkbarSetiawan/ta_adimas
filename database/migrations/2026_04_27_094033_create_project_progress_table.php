<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Laporan progres yang diupload oleh tim operasional
        Schema::create('project_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('operational_id')->constrained('users')->onDelete('cascade');
            $table->string('title');           // judul laporan progres
            $table->text('description');       // deskripsi pekerjaan yang dilakukan
            $table->unsignedTinyInteger('percentage')->default(0); // 0-100
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_progress');
    }
};