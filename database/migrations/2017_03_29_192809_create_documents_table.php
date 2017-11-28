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
            $table->tinyInteger('periodicity')->default(1)->comment = '1 = Periódicos, 2 = Quando Solicitado';
            $table->integer('validity')->unsigned();
            $table->integer('documentTypeId')->unsigned();
            $table->integer('entityGroup')->unsigned()->comment = '1 = company, 2 = provider, 3 = employee';
            $table->boolean('isActive')->default(true);
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
        });

        //ALTER TABLE documents ADD COLUMN isActive tinyint(1) DEFAULT 1 AFTER entityGroup;
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
