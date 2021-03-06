<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_id');
            $table->unsignedInteger('social_link_type_id');
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('crew_id')
                ->references('id')
                ->on('crews')
                ->onDelete('cascade');

            $table->foreign('social_link_type_id')
                ->references('id')
                ->on('social_link_types')
                ->onDelete('cascade');

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
        Schema::dropIfExists('crew_social');
    }
}
