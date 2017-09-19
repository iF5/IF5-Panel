<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsHasProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_has_providers', function (Blueprint $table) {
            $table->integer('documentId')->unsigned();
            $table->integer('providerId')->unsigned();
            $table->integer('validity')->unsigned();
            $table->tinyInteger('status')->comment = '';
            $table->dateTime('sentAt')->nullable();
            $table->dateTime('approvedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_has_providers');
    }
}
