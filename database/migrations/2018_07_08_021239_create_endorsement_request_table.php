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
            $table->unsignedInteger('endorsement_id');
            $table->string('token');
            $table->text('message');
            $table->timestamps();

            $table->foreign('endorsement_id')
                ->references('id')
                ->on('endorsement')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->index('token');
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
