<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL requires modifying the enum definition directly
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','member','trainer','pending_trainer') NOT NULL DEFAULT 'member'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','member','trainer') NOT NULL DEFAULT 'member'");
    }
};