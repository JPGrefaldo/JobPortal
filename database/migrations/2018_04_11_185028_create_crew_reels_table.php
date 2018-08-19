<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewReelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_reels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crew_id')->unsigned();
            $table->string('url');
            $table->boolean('general')->default(false);
            $table->integer('crew_position_id')->unsigned()->nullable()->default(null);
            $table->timestamps();

            $table->foreign('crew_id')
                  ->references('id')
                  ->on('crews')
                  ->onDelete('cascade');

            $table->foreign('crew_position_id')
                  ->references('id')
                  ->on('crew_positions')
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
        Schema::dropIfExists('crew_reels');
    }
}
