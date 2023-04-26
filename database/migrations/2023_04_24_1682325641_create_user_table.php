<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {

		$table->string('name',100);
		$table->string('surname',150);
		$table->bigInteger('personalCode');
		$table->string('email',100);
		$table->integer('grade')->default(0);
		$table->string('password');
		$table->string('speciality')->nullable()->default('NULL');
		$table->integer('iat')->nullable()->default(0);
		$table->string('cv')->nullable()->default('NULL');
		$table->date('created_at');
		$table->date('updated_at')->nullable();
		$table->integer('role')->default(1);
		$table->integer('confirmation')->nullable()->default(1);
		$table->integer('id_User', true);
		$table->integer('fk_Classid_Class')->nullable();
		$table->integer('fk_Schoolid_School')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
