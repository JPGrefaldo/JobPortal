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
            $table->integer('endorsee_id')
                  ->unsigned()
                  ->foreign('endorsee_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->integer('endorser_email')
                  ->unsigned()
                  ->foreign('endorser_email')
                  ->references('email')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->text('comment');
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
