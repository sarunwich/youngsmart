<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_relations', function (Blueprint $table) {
            $table->id();
            $table->string('pr_title',255)->nullable();
            $table->string('pr_detail',255)->nullable();
            $table->dateTime('pr_date')->nullable();
            $table->string('pr_file',255)->nullable();
            $table->string('pr_staus',2)->nullable();
            $table->integer('id_admin');
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
        Schema::dropIfExists('public_relations');
    }
}
