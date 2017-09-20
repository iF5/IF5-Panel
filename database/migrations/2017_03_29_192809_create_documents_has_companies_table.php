<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsHasCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_has_companies', function (Blueprint $table) {
            $table->integer('documentId')->unsigned();
            $table->integer('companyId')->unsigned();
            $table->date('referenceDate');
            $table->integer('validity')->unsigned();
            $table->tinyInteger('status')->default(1)->comment = '1 = enviado, 2 = aprovado, 3 = reprovado';
            $table->dateTime('sentAt');
            $table->dateTime('resentAt')->nullable();
            $table->dateTime('approvedAt')->nullable();
            $table->dateTime('reusedAt')->nullable();
            $table->string('fileName')->nullable();
            $table->string('originalFileName')->nullable();
            $table->primary(['documentId', 'companyId', 'referenceDate'], 'pk_d_c_r');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_has_companies');
    }
}
