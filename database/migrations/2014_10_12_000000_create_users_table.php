<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('idcard',13)->nullable();
            $table->string('prefix',13)->nullable();
            $table->string('name');
            $table->string('gread')->nullable();
            $table->integer('level')->nullable();
            $table->string('belong',255)->nullable();
            $table->string('province')->nullable();
            $table->string('address')->nullable();
            $table->string('tel',10)->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_tel',10)->nullable();
            $table->string('user_type')->nullable(); 
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
