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
            $table->integer('crew_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->text('details');
            $table->text('union_description');
            $table->timestamps();

            $table->foreign('crew_id')
                  ->references('id')
                  ->on('crews')
                  ->onDelete('cascade');

            $table->foreign('position_id')
                  ->references('id')
                  ->on('positions')
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
        Schema::dropIfExists('crew_positions');
    }
}
