<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update existing 'peminjam' roles to 'user'
        DB::statement("UPDATE users SET role = 'user' WHERE role = 'peminjam'");

        // Alter the enum to change 'peminjam' to 'user'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'user') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the enum to 'peminjam'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petugas', 'peminjam') DEFAULT 'peminjam'");
    }
};
