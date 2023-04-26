<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('lesson', function (Blueprint $table) {

      $table->dateTime('lessonsStartingTime');
      $table->dateTime('lessonsEndingTime');
      $table->integer('lowerGradeLimit')->nullable()->default(0);
      $table->integer('upperGradeLimit')->nullable()->default(12);
      $table->integer('type');
      $table->integer('id_lesson', true);
      $table->integer('fk_nonscholasticActivityid_nonscholasticActivity')->nullable();
      $table->integer('fk_Classroomid_Classroom');
      $table->integer('fk_Userid_User');
      $table->integer('fk_mainLessonsid_mainLessons')->nullable();

    });
  }

  public function down()
  {
    Schema::dropIfExists('lesson');
  }
};
