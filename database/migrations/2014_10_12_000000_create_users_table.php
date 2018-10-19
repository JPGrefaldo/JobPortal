<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')
                  ->unique();
            $table->string('phone', 15);
            $table->string('password');
            $table->rememberToken();
            $table->smallInteger('status')
                  ->default(1);
            $table->boolean('confirmed')
                  ->default(false);

            $table->timestamps();

            $table->index('uuid');
            $table->index('status');
            $table->index('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
