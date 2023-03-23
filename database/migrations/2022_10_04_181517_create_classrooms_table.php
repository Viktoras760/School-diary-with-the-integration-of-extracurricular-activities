<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('classroom', function (Blueprint $table) {

		$table->integer('Number');
        $table->integer('Floor_Number');
		$table->integer('Pupil_capacity');
		$table->enum('Musical_equipment',['Yra', 'Nėra'])->nullable();
		$table->enum('Chemistry_equipment',['Yra', 'Nėra'])->nullable();
		$table->enum('Computers',['Yra', 'Nėra'])->nullable();
		$table->integer('id_Classroom',true);
		$table->integer('fk_Schoolid_School');

        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom');
    }
};
