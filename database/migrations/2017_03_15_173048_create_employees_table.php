<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('cpf');
            $table->string('rg');
            $table->string('ctps');
            $table->string('birthDate');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('jobRole');
            $table->decimal('salaryCap', 10, 2);
            $table->string('hiringDate');
            $table->string('endingDate')->nullable();
            $table->string('pis');
            $table->string('workingHours');
            $table->string('workRegime');
            $table->boolean('hasChildren')->default(false);
            $table->integer('providerId');
            $table->boolean('status')->default(false);
            $table->mediumText('documents')->nullable();
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->unique(['cpf', 'providerId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
