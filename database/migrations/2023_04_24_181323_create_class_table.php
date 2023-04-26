<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('class', function (Blueprint $table) {

      $table->string('name',40);
      $table->integer('grade');
      $table->integer('classTeacherId');
      $table->integer('id_Class',true);

    });
  }

  public function down()
  {
    Schema::dropIfExists('class');
  }
};
