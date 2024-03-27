<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_id')->nullable();
            $table->foreignId('call_center_id')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->string('fname', 125);
            $table->string('lname', 125);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone', 25)->nullable();
            $table->string('avatar')->nullable();
            $table->string('center_name', 255)->nullable();
            $table->string('address_line', 255)->nullable();
            $table->string('city', 85)->nullable();
            $table->string('state', 35)->nullable();
            $table->string('zip_code', 30)->nullable();
            $table->string('country', 56)->nullable();
            $table->string('did_number', 255)->nullable();
            $table->unsignedInteger('lead_type')->nullable();
            $table->unsignedSmallInteger('lead_request_type')->nullable();
            $table->integer('lead_request_cap')->nullable();
            $table->text('api_url')->nullable();
            $table->integer('status')->default(1);
            $table->string('ip_address', 45)->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->timestamp('last_login_time')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE users AUTO_INCREMENT = 21402;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
