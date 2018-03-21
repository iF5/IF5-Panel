<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesHasDocumentsTable extends Migration
{

    protected $table = 'employees_has_documents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('employeeId')->unsigned();
            $table->integer('documentId')->unsigned();
            $table->dateTime('createdAt');
            $table->primary(['employeeId', 'documentId'], 'pk_e_d');
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
