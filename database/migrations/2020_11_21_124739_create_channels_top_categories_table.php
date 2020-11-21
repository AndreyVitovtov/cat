<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTopCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_top_categories', function (Blueprint $table) {
            $table->integer('channels_id')->unsigned();
            $table->integer('categories_id')->unsigned();

            $table->index(['channels_id', 'categories_id']);

            $table->foreign('channels_id')
                ->references('id')->on('channels')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('categories_id')
                ->references('id')->on('categories')
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
        Schema::dropIfExists('channels_top_categories');
    }
}
