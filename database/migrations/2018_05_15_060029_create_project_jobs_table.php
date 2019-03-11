<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('pay_type_id');
            $table->unsignedInteger('persons_needed')
                ->default(1);
            $table->text('dates_needed');
            $table->decimal('pay_rate')
                ->default(0);
            $table->text('notes')
                ->nullable();
            $table->boolean('rush_call');
            $table->boolean('travel_expenses_paid');
            $table->string('gear_provided')
                ->nullable()
                ->default(null);
            $table->string('gear_needed')
                ->nullable()
                ->default(null);
            $table->smallInteger('status')
                ->default(0);
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->foreign('pay_type_id')
                ->references('id')
                ->on('pay_types')
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
        Schema::dropIfExists('project_jobs');
    }
}
