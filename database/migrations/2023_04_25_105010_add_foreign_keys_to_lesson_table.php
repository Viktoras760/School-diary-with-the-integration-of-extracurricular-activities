<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson', function (Blueprint $table) {
          $table->foreign(['fk_mainLessonsid_mainLessons'], 'Lesson_associatesWith_mainLesson')->references(['id_mainLessons'])->on('mainlessons');
          $table->foreign(['fk_nonscholasticActivityid_nonscholasticActivity'], 'Lesson_associatesWith_nonscholasticactivity')->references(['id_nonscholasticActivity'])->on('nonscholasticactivity');
          $table->foreign(['fk_Classroomid_Classroom'], 'Lesson_have_classroom')->references(['id_Classroom'])->on('classroom');
          $table->foreign(['type'], 'Lesson_lesson_ibfk_1_type')->references(['id_lessonType'])->on('lessontype');
          $table->foreign(['fk_Userid_User'], 'Lesson_makes_user')->references(['id_User'])->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson', function (Blueprint $table) {
          $table->dropForeign('Lesson_associatesWith_mainLesson');
          $table->dropForeign('Lesson_associatesWith_nonscholasticactivity');
          $table->dropForeign('Lesson_have_classroom');
          $table->dropForeign('Lesson_lesson_ibfk_1_type');
          $table->dropForeign('Lesson_makes_user');
        });
    }
};
