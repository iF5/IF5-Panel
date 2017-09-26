<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_checklists', function (Blueprint $table) {
            $table->integer('entityGroup')->unsigned()->comment = '1 = company, 2 = provider, 3 = employee';
            $table->integer('entityId')->unsigned();
            $table->integer('documentId')->unsigned();
            $table->date('referenceDate');
            $table->integer('validity')->unsigned();
            $table->tinyInteger('status')->default(1)->comment = '1 = enviado, 2 = aprovado, 3 = reprovado';
            $table->dateTime('sentAt');
            $table->dateTime('resentAt')->nullable();
            $table->dateTime('approvedAt')->nullable();
            $table->dateTime('reusedAt')->nullable();
            $table->string('fileName')->nullable();
            $table->string('originalFileName')->nullable();
            $table->primary(['entityGroup', 'entityId', 'documentId', 'referenceDate'], 'pk_e_e_d_r');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_checklists');
    }
}
