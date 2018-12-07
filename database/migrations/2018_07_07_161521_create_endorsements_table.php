<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endorsements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_position_id');
            $table->unsignedInteger('endorsement_request_id');
            $table->datetime('approved_at')
                  ->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('endorsement_request_id')
                  ->references('id')
                  ->on('endorsement_requests')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('crew_position_id')
                  ->references('id')
                  ->on('crew_position')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endorsements');
    }
}
