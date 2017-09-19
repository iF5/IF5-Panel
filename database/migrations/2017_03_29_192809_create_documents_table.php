<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->boolean('isHomologated')->default(false);
            $table->boolean('isMonthly')->default(false);
            $table->boolean('isSemester')->default(false);
            $table->boolean('isYearly')->default(false);
            $table->boolean('isSolicited')->default(false);
            $table->boolean('provider')->default(false);
        });
    }
    */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->tinyInteger('periodicity')->comment = '1 = Periódicos, 2 = Quando Solicitado';
            $table->integer('validity')->unsigned();
            $table->integer('documentTypeId')->unsigned();
            $table->integer('entityId')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
