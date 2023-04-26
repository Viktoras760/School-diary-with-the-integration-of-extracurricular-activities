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
        Schema::table('mainlessons', function (Blueprint $table) {
            $table->foreign(['fk_Classid_Class'], 'mainlessons_has_mandatory_class')->references(['id_Class'])->on('class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mainlessons', function (Blueprint $table) {
            $table->dropForeign('mainlessons_has_mandatory_class');
        });
    }
};
