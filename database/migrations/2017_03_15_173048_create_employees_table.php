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
            $table->date('birthDate');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('jobRole');
            $table->decimal('salaryCap', 10, 2);
            $table->date('hiringDate');
            $table->string('pis');
            $table->string('workingHours');
            $table->string('workRegime');

            //Filhos
            $table->boolean('hasChildren')->default(false);

            //Demissao/Afastamento
            $table->boolean('layOff')->default(0)->comment = '0: Em atividade, 1: Afastado, 2: Demitido';
            $table->date('removalDate')->nullable();
            $table->integer('daysRemoval')->default(0);
            $table->date('dismissalDate')->nullable();

            $table->mediumText('documents')->nullable();
            $table->integer('providerId')->unsigned();
            $table->boolean('status')->default(false);
            $table->date('startAt')->nullable();
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
