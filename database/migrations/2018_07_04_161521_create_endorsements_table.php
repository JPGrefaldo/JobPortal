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
            $table->integer('project_job_id')->unsigned();
            $table->integer('endorser_id')->unsigned();
            $table->integer('endorsee_id')->unsigned();
            $table->timestamps();

            $table->unique(['project_job_id', 'endorser_id', 'endorsee_id']);

            $table->foreign('project_job_id')
                ->references('id')
                ->on('project_jobs')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('endorser_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('endorsee_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
