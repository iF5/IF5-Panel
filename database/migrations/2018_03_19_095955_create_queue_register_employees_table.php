<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueRegisterEmployeesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'queue_register_employees';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('fileName');
            $table->string('originalFileName');
            $table->boolean('status')->default(0)->comment = '0: Aguardando processamento, 1: Processado, 2: Erro no processamento';
            $table->text('message')->nullable();
            $table->text('debugMessage')->nullable();
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
        Schema::dropIfExists($this->table);
    }
}
