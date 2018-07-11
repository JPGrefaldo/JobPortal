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
            $table->integer('crew_position_id')
                  ->unsigned()
                  ->foreign('crew_position_id')
                  ->references('id')
                  ->on('crew_positions')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->string('endorser_email');
            $table->text('comment')->nullable();
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('endorsements');
    }
}
