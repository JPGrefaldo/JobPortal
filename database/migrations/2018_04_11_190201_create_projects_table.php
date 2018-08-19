<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->text('production_name');
            $table->boolean('production_name_public')->default(true);
            $table->smallInteger('status')->default(0);
            $table->integer('project_type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->string('location')->nullable();
            $table->timestamps();

            $table->foreign('project_type_id')
                  ->references('id')
                  ->on('project_types')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('site_id')
                  ->references('id')
                  ->on('sites')
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
        Schema::dropIfExists('projects');
    }
}
