<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classroom', function (Blueprint $table) {

		$table->string('number',8);
		$table->integer('floorNumber');
		$table->integer('pupilCapacity');
		$table->tinyInteger('musicalEquipment');
		$table->tinyInteger('chemistryEquipment');
		$table->tinyInteger('computers');
		$table->integer('id_classroom', true);
		$table->integer('fk_Schoolid_School');

        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom');
    }
};
