<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('username', 100)->unique();
            $table->string('email',255)->unique();
            $table->string('password',255);
            $table->string('firstname',255);
            $table->string('middlename',255);
            $table->string('lastname',255);
            $table->timestamps();
            // Schema declaration
            // Constraints declaration

        });

        /**
         *  insert default value as superagent
         */
        DB::table('users')->insert([
                'uuid' => Uuid::uuid1(),
                'username' => 'superadmin',
                'email' => 'superadmin@mailinator.com',
                'password' => Hash::make('12345678'),
                'firstname' => 'superadmin',
                'middlename' => 'superadmin',
                'lastname' => 'superadmin'
            ]
        );

    }

    public function down()
    {
        Schema::drop('users');
    }
}
