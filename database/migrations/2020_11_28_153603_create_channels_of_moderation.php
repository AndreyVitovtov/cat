<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsOfModeration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_of_moderation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('messenger_id')->unsigned();
            $table->string('link');
            $table->date('date');
            $table->time('time');

            $table->index(['users_id', 'messenger_id']);

            $table->foreign('users_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('messenger_id')
                ->references('id')->on('messenger')
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
        Schema::dropIfExists('channels_of_moderation');
    }
}
