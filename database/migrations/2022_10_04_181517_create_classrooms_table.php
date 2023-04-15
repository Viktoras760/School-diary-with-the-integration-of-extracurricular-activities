<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classroom', function (Blueprint $table) {

		$table->integer('number');
    $table->integer('floorNumber');
		$table->integer('pupilCapacity');
		$table->enum('musicalEquipment',['Yes', 'No'])->nullable();
		$table->enum('chemistryEquipment',['Yes', 'No'])->nullable();
		$table->enum('computers',['Yes', 'No'])->nullable();
		$table->integer('id_Classroom',true);
		$table->integer('fk_Schoolid_School');

        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom');
    }
};
