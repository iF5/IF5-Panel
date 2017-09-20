<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsHasEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_has_entities', function (Blueprint $table) {
            $table->integer('entityGroup')->unsigned();
            $table->integer('entityId')->unsigned();
            $table->mediumText('documents');
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->primary(['entityGroup', 'entityId'], 'pk_eg_ei');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_has_entities');
    }
}
