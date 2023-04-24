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
            $table->foreign(['fk_Classroomid_Classroom'], 'Lesson_BelongsTo_Classroom')->references(['id_Classroom'])->on('classroom');
            $table->foreign(['creatorId'], 'Lesson_BelongsTo_Creator')->references(['id_User'])->on('user');
            //$table->foreign(['fk_Userid_User'], 'Lesson_CreatedBy_User')->references(['id_User'])->on('user');
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
            $table->dropForeign('Lesson_BelongsTo_Classroom');
            $table->dropForeign('Lesson_BelongsTo_Creator');
            //$table->dropForeign('Lesson_CreatedBy_User');
        });
    }
};
