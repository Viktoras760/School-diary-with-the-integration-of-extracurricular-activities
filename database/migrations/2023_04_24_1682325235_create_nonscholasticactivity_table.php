<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nonscholasticactivity', function (Blueprint $table) {

		$table->string('name');
		$table->float('price')->nullable()->default(0.00);
    $table->string('description')->nullable()->default('NULL');
		$table->integer('id_nonscholasticActivity', true);

        });
    }

    public function down()
    {
        Schema::dropIfExists('nonscholasticactivity');
    }
};
