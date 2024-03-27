<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_id');
            $table->foreignId('agent_id');
            $table->foreignId('call_center_id');
            $table->foreignId('client_id')->nullable();
            $table->foreignId('external_id')->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->date('dob');
            $table->string('phone', 25);
            $table->unsignedInteger('quote');
            $table->string('address_line', 255)->nullable();
            $table->string('city', 85)->nullable();
            $table->string('state', 35)->nullable();
            $table->string('zip_code', 30)->nullable();
            $table->string('country', 56)->nullable();
            $table->string('owner_type')->nullable();
            $table->string('home_type')->nullable();
            $table->string('insured_by', 255)->nullable();
            $table->unsignedInteger('insurance_duration')->nullable();
            $table->unsignedInteger('cars_owned')->nullable();
            $table->string('make', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('year', 4)->nullable();
            $table->unsignedInteger('call_time');
            $table->unsignedSmallInteger('assign_type')->nullable();
            $table->dateTime('assigned_time')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE leads AUTO_INCREMENT = 17452965;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
