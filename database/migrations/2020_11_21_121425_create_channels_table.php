<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->integer('users_id')->unsigned();
            $table->integer('moderation')->default(0);
            $table->integer('countries_id')->unsigned();
            $table->integer('categories_id')->unsigned();

            $table->index(['users_id', 'countries_id', 'categories_id']);

            $table->foreign('users_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('countries_id')
                ->references('id')->on('countries')
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
        Schema::dropIfExists('channels');
    }
}
