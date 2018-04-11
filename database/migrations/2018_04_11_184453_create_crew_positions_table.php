<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crew_id')->unsigned()
                  ->foreign('crew_id')
                  ->references('id')
                  ->on('crews')
                  ->onDelete('cascade');
            $table->integer('position_id')->unsigned()
                  ->foreign('position_id')
                  ->references('id')
                  ->on('positions')
                  ->onDelete('cascade');
            $table->text('details');
            $table->text('union_description');
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
        Schema::dropIfExists('crew_positions');
    }
}
