<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesHasDocumentsTable extends Migration
{

    protected $table = 'companies_has_documents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('companyId')->unsigned();
            $table->integer('documentId')->unsigned();
            $table->dateTime('createdAt');
            $table->primary(['companyId', 'documentId'], 'pk_c_d');
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
