<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE users MODIFY role ENUM('super_admin', 'lurah', 'staf') DEFAULT 'staf'"
            );
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE users MODIFY role ENUM('super_admin', 'staf') DEFAULT 'staf'"
            );
        }
    }
};