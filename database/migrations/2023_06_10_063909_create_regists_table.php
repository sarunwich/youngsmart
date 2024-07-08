<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project')->unsigned();
            $table->foreign('project')->references('id')->on('projects');
            $table->bigInteger('course')->unsigned();
            $table->foreign('course')->references('id')->on('courses');
            $table->bigInteger('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users');
            $table->string('link',500)->nullable();
            $table->string('facebook',13)->nullable();
            $table->string('line',13)->nullable();
            
            $table->string('stdpic',255)->nullable();
            $table->string('school_record',255)->nullable();
            $table->dateTime('dateup_sr')->nullable();
            $table->string('payment',255)->nullable();
            $table->dateTime('dateup_p')->nullable();
            $table->string('std_status',13)->nullable();
            $table->string('guidance_teacher',255)->nullable();
            $table->string('portfolio_file',255)->nullable();
           
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
        Schema::dropIfExists('regists');
    }
}
