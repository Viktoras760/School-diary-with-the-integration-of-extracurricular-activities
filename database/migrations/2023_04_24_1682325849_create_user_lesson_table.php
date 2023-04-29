<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_lesson', function (Blueprint $table) {

		$table->integer('mark')->nullable();
		$table->string('comment')->nullable()->default('NULL');
		$table->tinyInteger('Attended')->nullable()->default(1);
		$table->integer('id_user_lesson', true);
		$table->integer('fk_Lessonid_Lesson');
		$table->integer('fk_Userid_User');

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_lesson');
    }
};
