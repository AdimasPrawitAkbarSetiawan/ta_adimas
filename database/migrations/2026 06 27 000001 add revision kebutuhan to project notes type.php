<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE project_notes MODIFY COLUMN type ENUM('revision','approval','rejection','info','revision_kebutuhan') NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE project_notes MODIFY COLUMN type ENUM('revision','approval','rejection','info') NOT NULL DEFAULT 'info'");
    }
};