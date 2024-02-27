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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('designation')->nullable();
            $table->string('national_id_number')->unique();
            $table->string('permanent_address', 255)->nullable();
            $table->string('present_address', 255)->nullable();
            $table->string('gender');
            $table->tinyInteger('is_verified')->default(0)->comment("0 for not verified, 1 for verified");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tmp_password')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
