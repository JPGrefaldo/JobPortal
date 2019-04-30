<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewPositionEndorsementScores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_position_endorsement_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_position_id');
            $table->unsignedInteger('score');
            $table->timestamps();

            $table->foreign('crew_position_id')
                ->references('id')
                ->on('crew_position')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('crew_position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew_position_endorsement_scores');
    }
}
