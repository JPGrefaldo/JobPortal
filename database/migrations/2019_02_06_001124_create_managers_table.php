<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manager_id');
            $table->unsignedInteger('subordinate_id');
            $table->smallInteger('status')
                  ->default(0);
            $table->timestamps();

            $table->unique(['manager_id', 'subordinate_id']);

            $table->foreign('manager_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('subordinate_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}
