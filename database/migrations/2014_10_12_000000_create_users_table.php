<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('cpf')->unique();
            $table->string('jobRole');
            $table->string('department');
            $table->string('phone')->nullable();
            $table->string('cellPhone');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('image')->default('no-profile-image.jpg');
            //$table->boolean('isAllPrivileges')->default(false);
            $table->dateTime('createdAt');
            $table->dateTime('updatedAt');
            $table->integer('companyId')->default(0);
            $table->integer('providerId')->default(0);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
