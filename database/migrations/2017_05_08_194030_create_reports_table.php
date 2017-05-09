<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('referenceDate');
            $table->string('fileName')->nullable();
            $table->string('fileOriginalName')->nullable();
            $table->integer('companyId')->unsigned();
            $table->dateTime('createdAt');
            $table->dateTime('sentAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
