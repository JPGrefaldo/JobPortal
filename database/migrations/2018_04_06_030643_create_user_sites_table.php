<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()
                  ->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->integer('site_id')->unsigned()
                  ->foreign('site_id')
                  ->references('id')
                  ->on('sites')
                  ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sites');
    }
}
