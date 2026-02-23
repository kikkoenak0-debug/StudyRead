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
        Schema::create('logged_in_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('logged_at')->useCurrent();
            $table->timestamp('last_active_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            $table->unique(['session_id', 'user_id']);
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logged_in_accounts');
    }
};
