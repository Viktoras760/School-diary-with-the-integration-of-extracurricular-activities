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
        Schema::create('user_lesson', function (Blueprint $table) {
            $table->integer('mark')->nullable();
            $table->string('comment')->nullable();
            $table->integer('fk_Userid_User');
            $table->integer('fk_Lessonid_Lesson')->index('fk_Lessonid_Lesson');

            $table->primary(['fk_Userid_User', 'fk_Lessonid_Lesson'], 'user_lesson_pkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_lesson');
    }
};
