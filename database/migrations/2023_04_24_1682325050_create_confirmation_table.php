<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('confirmation', function (Blueprint $table) {

		$table->integer('id_Confirmation',true);
		$table->char('name',11);

        });
    }

    public function down()
    {
        Schema::dropIfExists('confirmation');
    }
};
