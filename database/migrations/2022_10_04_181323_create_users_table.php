<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {

		$table->string('name');
		$table->string('surname');
		$table->biginteger('personalCode');
		$table->string('email')->nullable()->default('NULL');
    $table->enum('grade',[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])->default(0);
		$table->string('password');
    $table->biginteger('iat')->nullable()->default(0);
		$table->enum('confirmation', ['Confirmed', 'Unconfirmed', 'Declined'])->default('Unconfirmed');
		$table->integer('id_User',true);
		$table->integer('fk_Schoolid_School')->nullable();
		$table->enum('role',['Pupil','Teacher','School Administrator','System Administrator'])->default('Pupil');
    $table->binary('cv')->nullable();
        $table->rememberToken();
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
