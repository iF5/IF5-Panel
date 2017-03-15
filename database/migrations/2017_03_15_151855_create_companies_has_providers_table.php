<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesHasProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_has_providers', function (Blueprint $table) {
            $table->integer('companyId')->unsigned();
            $table->integer('providerId')->unsigned();
            $table->primary(['companyId', 'providerId'], 'pk_c_p_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_has_providers');
    }
}
