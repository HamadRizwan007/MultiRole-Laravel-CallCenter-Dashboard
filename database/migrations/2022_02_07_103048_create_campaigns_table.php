<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_id');
            $table->foreignId('client_id');
            $table->foreignId('state_id');
            $table->text('lead_types');
            $table->text('lead_request_types');
            $table->string('did_number', 255)->nullable();
            $table->unsignedInteger('daily_leads')->nullable();
            $table->decimal('admin_price', 10, 2, true)->nullable();
            $table->decimal('center_price', 10, 2, true)->nullable();
            $table->unsignedTinyInteger('status')->default(2);
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
        Schema::dropIfExists('campaigns');
    }
}
