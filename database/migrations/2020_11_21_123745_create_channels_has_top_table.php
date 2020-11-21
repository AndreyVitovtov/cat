<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsHasTopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_has_top', function (Blueprint $table) {
            $table->integer('channels_id')->unsigned();
            $table->integer('top_id')->unsigned();

            $table->index(['channels_id', 'top_id']);

            $table->foreign('channels_id')
                ->references('id')->on('channels')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('top_id')
                ->references('id')->on('top')
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
        Schema::dropIfExists('channels_has_top');
    }
}
