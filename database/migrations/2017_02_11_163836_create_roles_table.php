<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{

    public function up()
    {
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            // Schema declaration
            // Constraints declaration

        });
    }

    public function down()
    {
        Schema::drop('roles');
    }
}
