<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewGearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_gears', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_id');
            $table->text('description');
            $table->unsignedInteger('crew_position_id')
                ->nullable()
                ->default(null);
            $table->timestamps();

            $table->foreign('crew_id')
                ->references('id')
                ->on('crews')
                ->onDelete('cascade');

            $table->foreign('crew_position_id')
                ->references('id')
                ->on('crew_position')
                ->onDelete('cascade');

            $table->index('crew_id');
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
        Schema::dropIfExists('crew_gear');
    }
}
