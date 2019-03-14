<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('hash_id')
                ->unique()
                ->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')
                ->nullable();
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

            $table->index('status');
            $table->index('confirmed');
            $table->index('email');
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
