<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE projects MODIFY COLUMN status ENUM('draft','review','revision','approved','pending_detail','in_progress','completed','rejected') NOT NULL DEFAULT 'draft'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE projects MODIFY COLUMN status ENUM('draft','review','revision','approved','in_progress','completed','rejected') NOT NULL DEFAULT 'draft'");
    }
};