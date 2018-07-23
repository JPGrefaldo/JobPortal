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
            $table->integer('endorsement_request_id')->unsigned();
            $table->integer('endorser_id')->unsigned();
            $table->datetime('approved_at')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('endorsement_request_id')
                ->references('id')
                ->on('endorsement_requests')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('endorser_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('endorsements');
    }
}
