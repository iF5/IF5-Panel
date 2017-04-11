<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesHasDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_has_documents', function (Blueprint $table) {
            $table->integer('employeeId')->unsigned();
            $table->integer('documentId')->unsigned();
            $table->enum('status',[1,2,3]);
            $table->date('referenceDate');
            $table->dateTime('sendDate');
            $table->dateTime('receivedDate');
            $table->boolean('validated')->default(false);
            $table->primary(['employeeId', 'documetId'], 'pk_e_c_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_has_documents');
    }
}
