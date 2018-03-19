<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueRegisterEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_register_employees', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('fileName');
            $table->string('originalFileName');
            $table->boolean('status')->default(0)->comment = '0: Aguardando processamento, 1: Processado, 2: Erro no processamento';
            $table->integer('providerId')->unsigned();
            $table->dateTime('createdAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queue_register_employees');
    }
}
