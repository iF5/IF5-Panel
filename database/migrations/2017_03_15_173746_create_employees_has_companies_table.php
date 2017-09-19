<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesHasCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_has_companies', function (Blueprint $table) {
            $table->integer('employeeId')->unsigned();
            $table->integer('companyId')->unsigned();
            $table->primary(['employeeId', 'companyId'], 'pk_e_c_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_has_companies');
    }
}
