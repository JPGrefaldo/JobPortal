<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewEndorsementScoreSweetener extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_endorsement_score_sweeteners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('crew_id');
            $table->unsignedInteger('sweetener');
            $table->timestamps();

            $table->foreign('crew_id')
                ->references('id')
                ->on('crew')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('crew_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew_endorsement_score_sweeteners');
    }
}
