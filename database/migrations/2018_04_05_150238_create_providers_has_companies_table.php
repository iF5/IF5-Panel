<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersHasCompaniesTable extends Migration
{

    protected $table = 'providers_has_companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('providerId')->unsigned();
            $table->integer('companyId')->unsigned();
            $table->boolean('status')->default(false);
            $table->dateTime('createdAt');
            $table->primary(['providerId', 'companyId'], 'pk_p_c_id');
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
