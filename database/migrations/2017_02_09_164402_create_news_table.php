<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{

    public function up()
    {
        Schema::create('news', function(Blueprint $table) {
            $table->increments('id');
            // Schema declaration
            // Constraints declaration

        });
    }

    public function down()
    {
        Schema::drop('news');
    }
}
