<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingFlagMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_flag_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('message_id');
            $table->text('reason');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disapproved_at')->nullable();
            $table->timestamps();

            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
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
        Schema::dropIfExists('pending_flag_messages');
    }
}
