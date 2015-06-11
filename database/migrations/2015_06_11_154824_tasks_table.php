<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('color_id')
            ->unsigned();

            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('repeatable');
            $table->enum('interval', ["day", "week", "month", "year"]);
            $table->integer('category_id')->unsigned();
            $table->integer('status_id')->unsigned();

            $table->foreign('color_id')
            ->references('id')
            ->on('colors')
            ->onDelete('restrict');

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('restrict');

            $table->foreign('status_id')
            ->references('id')
            ->on('statuses')
            ->onDelete('restrict');

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
        Schema::drop('tasks');
    }
}
