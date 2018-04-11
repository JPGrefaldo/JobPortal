<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewGearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_gear', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crew_id')->unsigned()
                  ->foreign('crew_id')
                  ->references('id')
                  ->on('crews')
                  ->onDelete('cascade');
            $table->text('description');
            $table->integer('crew_position_id')->unsigned()->nullable()->default(null)
                  ->foreign('crew_position_id')
                  ->references('id')
                  ->on('crew_positions')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew_gear');
    }
}
