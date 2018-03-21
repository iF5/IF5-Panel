<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterBatchEmployeesTable extends Migration
{
    /**
     * @var string
     */
    protected $table = 'register_batch_employees';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('delimiter', 5);
            $table->string('fileName')->nullable();
            $table->string('originalFileName')->nullable();
            $table->boolean('status')->default(0)->comment = '0: Aguardando processamento, 1: Processado, 2: Erro no processamento';
            $table->text('message')->nullable();
            $table->text('debugMessage')->nullable();
            $table->mediumText('affectedItems')->nullable();
            $table->integer('providerId')->unsigned();
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
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
