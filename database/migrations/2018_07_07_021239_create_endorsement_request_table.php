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
            $table->unsignedInteger('endorsement_endorser_id');
            $table->string('token');
            $table->text('message');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('endorsement_endorser_id')
                ->references('id')
                ->on('endorsement_endorsers')
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
