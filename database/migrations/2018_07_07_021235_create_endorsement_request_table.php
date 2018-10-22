<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndorsementRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endorsement_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_position_id');
            $table->string('token')
                  ->index();
            $table->timestamps();

            $table->foreign('crew_position_id')
                ->references('id')
                ->on('crew_position')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endorsement_requests');
    }
}
