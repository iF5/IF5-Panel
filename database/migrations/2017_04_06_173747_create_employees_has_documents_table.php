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
            $table->enum('status',[1,2,3])->default(1);
            $table->date('referenceDate')->nullable();
            $table->dateTime('sendDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('reSendDate')->nullable();
            $table->dateTime('receivedDate')->nullable();
            $table->boolean('validated')->default(false);
            $table->string('finalFileName');
            $table->string('originalFileName');
            $table->primary(['employeeId', 'documentId', 'referenceDate'], 'pk_e_c_id');
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
