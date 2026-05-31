<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Foto bukti progres pekerjaan
        Schema::create('progress_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progress_id')->constrained('project_progress')->onDelete('cascade');
            $table->string('file_path');        // path file di storage
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_photos');
    }
};