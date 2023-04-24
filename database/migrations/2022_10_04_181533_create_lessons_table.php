<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lesson', function (Blueprint $table) {

		$table->string('lessonsName');
		$table->dateTimeTz('lessonsStartingTime');
        $table->dateTimeTz('lessonsEndingTime');
		$table->integer('id_Lesson',true);
        $table->integer('lowerGradeLimit');
        $table->integer('upperGradeLimit');
		$table->integer('fk_Classroomid_Classroom');
        $table->integer('creatorId');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson');
    }
};
