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
        Schema::table('user_lesson', function (Blueprint $table) {
            $table->foreign(['fk_Userid_User'], 'user_lesson_fk_1')->references(['id_User'])->on('user')->OnDelete('cascade');
            $table->foreign(['fk_Lessonid_Lesson'], 'user_lesson_fk_2')->references(['id_Lesson'])->on('lesson')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_lesson', function (Blueprint $table) {
            $table->dropForeign('user_lesson_fk_1');
            $table->dropForeign('user_lesson_fk_2');
        });
    }
};
