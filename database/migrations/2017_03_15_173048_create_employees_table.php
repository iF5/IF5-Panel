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
            $table->string('street');
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
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->unique(['cpf', 'providerId']);
        });

        /**
         *
        Dados pessoais:

        Nome:
        CPF:
        RG:

        CTPS Número
        Data de nascimento:
        Endereço:

        Bairro:
        Cidade:
        Estado:


        Dados profissionais:

        Função
        Piso Salarial
        Data contratação

        data da rescisão
        número do PIS
        jornada de trabalho = (diurno/noturno)

        regime de trabalho = (padrão ou 12x36)
        filhos menores (sim/não)
        empresas alocadas
         */
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
