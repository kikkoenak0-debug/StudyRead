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
        DB::statement("ALTER TABLE pinjaman MODIFY COLUMN status ENUM('pending', 'approved_pending_payment', 'paid', 'approved', 'rejected', 'returned') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE pinjaman MODIFY COLUMN status ENUM('pending', 'approved_pending_payment', 'approved', 'rejected', 'returned') DEFAULT 'pending'");
    }
};
