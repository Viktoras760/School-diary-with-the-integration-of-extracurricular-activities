<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessontype', function (Blueprint $table) {

		$table->integer('id_lessonType',true);
		$table->char('name',9);

        });
    }

    public function down()
    {
        Schema::dropIfExists('lessontype');
    }
};
