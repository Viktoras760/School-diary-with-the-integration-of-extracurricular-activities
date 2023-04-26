<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {

		$table->integer('id_Role',true);
		$table->char('name',20);

        });
    }

    public function down()
    {
        Schema::dropIfExists('role');
    }
};
