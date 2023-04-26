<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mainlessons', function (Blueprint $table) {

		$table->string('name',40);
		$table->string('lessonsType',60);
		$table->integer('id_mainLessons', true);
		$table->integer('fk_Classid_Class')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('mainlessons');
    }
};
