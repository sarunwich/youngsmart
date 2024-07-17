<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('Projectname',255)->nullable();
            $table->string('Projectfile',255)->nullable();
            $table->longText('Projectdetail')->nullable();
            $table->string('tcas',20)->nullable();
            $table->string('year',20)->nullable();
            $table->string('status',2)->nullable();
            $table->string('teacher',2)->nullable();
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
        Schema::dropIfExists('projects');
    }
}
