<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');

            $table->unsignedTinyInteger('monday_timing')->nullable();
            $table->text('monday_time_sets')->nullable();

            $table->unsignedTinyInteger('tuesday_timing')->nullable();
            $table->text('tuesday_time_sets')->nullable();

            $table->unsignedTinyInteger('wednesday_timing')->nullable();
            $table->text('wednesday_time_sets')->nullable();

            $table->unsignedTinyInteger('thursday_timing')->nullable();
            $table->text('thursday_time_sets')->nullable();

            $table->unsignedTinyInteger('friday_timing')->nullable();
            $table->text('friday_time_sets')->nullable();

            $table->unsignedTinyInteger('saturday_timing')->nullable();
            $table->text('saturday_time_sets')->nullable();

            $table->unsignedTinyInteger('sunday_timing')->nullable();
            $table->text('sunday_time_sets')->nullable();

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
        Schema::dropIfExists('client_timetables');
    }
}
