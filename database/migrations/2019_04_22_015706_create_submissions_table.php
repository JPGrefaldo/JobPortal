<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('crew_id');
            $table->unsignedInteger('project_job_id');
            $table->timestamps();

            $table->unique(
                [
                    'crew_id',
                    'project_job_id'
                ]
            );

            $table->foreign('crew_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('project_job_id')
                ->references('id')
                ->on('project_jobs')
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
        Schema::dropIfExists('submissions');
    }
}