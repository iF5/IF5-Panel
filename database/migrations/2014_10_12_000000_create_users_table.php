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
            $table->string('cpf');
            $table->string('jobRole');
            $table->string('department');
            $table->string('phoneNumber');
            $table->string('cellPhoneNumber');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('image')->default('no-profile-image.jpg');
            //$table->boolean('isAllPrivileges')->default(false);
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
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
