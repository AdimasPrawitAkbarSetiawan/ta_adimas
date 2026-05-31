<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_details', function (Blueprint $table) {
            $table->json('material')->nullable()->after('tools_materials');
            $table->json('alat_kerja')->nullable()->after('material');
        });
    }

    public function down(): void
    {
        Schema::table('project_details', function (Blueprint $table) {
            $table->dropColumn(['material', 'alat_kerja']);
        });
    }
};