<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('fantasyName');
            $table->string('activityBranch');
            $table->string('cnpj');
            $table->string('stateInscription');
            $table->string('municipalInscription');
            $table->string('mainCnae');
            $table->string('phone')->nullable();;
            $table->string('fax')->nullable();
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('responsibleName');
            $table->string('cellPhone')->nullable();
            $table->string('email');
            $table->date('startAt')->nullable();
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->unique(['name', 'cnpj']);
        });

        //ALTER TABLE providers ADD COLUMN startAt date AFTER documents;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
