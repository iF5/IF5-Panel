<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersHasDocumentsTable extends Migration
{

    protected $table = 'providers_has_documents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('providerId')->unsigned();
            $table->integer('documentId')->unsigned();
            $table->dateTime('createdAt');
            $table->primary(['providerId', 'documentId'], 'pk_p_d');
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
