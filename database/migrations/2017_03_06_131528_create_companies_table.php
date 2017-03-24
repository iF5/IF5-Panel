<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('cnpj', 191);
            $table->string('stateInscription');
            $table->string('municipalInscription');
            $table->string('mainCnae');
            $table->string('activityBranch');
            $table->string('cep');
            $table->string('number');
            $table->string('addressComplement');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->unique(['name', 'cnpj']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
