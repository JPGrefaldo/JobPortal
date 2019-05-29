<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('submission_id');
            $table->text('body');
            $table->timestamps();

            $table->foreign('submission_id')
                ->references('id')
                ->on('submissions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_notes');
    }
}
