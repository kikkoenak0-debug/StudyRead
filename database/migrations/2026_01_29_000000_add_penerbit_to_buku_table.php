<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('buku') && !Schema::hasColumn('buku', 'penerbit')) {
            Schema::table('buku', function (Blueprint $table) {
                $table->string('penerbit')->nullable()->after('penulis');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('buku') && Schema::hasColumn('buku', 'penerbit')) {
            Schema::table('buku', function (Blueprint $table) {
                $table->dropColumn('penerbit');
            });
        }
    }
};
