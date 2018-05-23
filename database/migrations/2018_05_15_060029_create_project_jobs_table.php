<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('persons_needed')->unsigned()->default(1);
            $table->string('dates_needed')->unsigned();
            $table->decimal('pay_rate')->default(0);
            $table->text('notes')->default('');
            $table->boolean('rush_call');
            $table->boolean('travel_expenses_paid');
            $table->string('gear_provided')->nullable()->default(null);
            $table->string('gear_needed')->nullable()->default(null);
            $table->smallInteger('status')->default(0);
            $table->integer('project_id')->unsigned()
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
            $table->integer('position_id')->unsigned()
                ->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');
            $table->integer('pay_type_id')->unsigned()
                ->foreign('pay_type_id')
                ->references('id')
                ->on('pay_types')
                ->onDelete('cascade');
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
        Schema::dropIfExists('project_jobs');
    }
}
