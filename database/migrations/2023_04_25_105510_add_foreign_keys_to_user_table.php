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
        Schema::table('user', function (Blueprint $table) {
          $table->foreign(['fk_Schoolid_School'], 'User_BelongsTo_School')->references(['id_School'])->on('school');
          $table->foreign(['fk_Classid_Class'], 'User_learns_in_class')->references(['id_Class'])->on('class');
          $table->foreign(['confirmation'], 'User_user_ibfk_1_confirmation')->references(['id_Confirmation'])->on('confirmation');
          $table->foreign(['role'], 'User_user_ibfk_2_role')->references(['id_Role'])->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
          $table->dropForeign('User_BelongsTo_School');
          $table->dropForeign('User_learns_in_class');
          $table->dropForeign('User_user_ibfk_1_confirmation');
          $table->dropForeign('User_user_ibfk_2_role');
        });
    }
};
