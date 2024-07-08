<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project')->unsigned();
            $table->foreign('project')->references('id')->on('projects');
            $table->bigInteger('course')->unsigned();
            $table->foreign('course')->references('id')->on('courses');
            $table->string('announcements')->nullable();
            $table->string('announcementsfile')->nullable();
            $table->string('status',2)->nullable();
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
        Schema::dropIfExists('announcements');
    }
}
