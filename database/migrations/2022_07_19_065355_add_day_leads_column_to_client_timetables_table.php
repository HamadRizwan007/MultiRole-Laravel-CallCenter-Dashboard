<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDayLeadsColumnToClientTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_timetables', function (Blueprint $table) {
            $table->unsignedInteger('monday_lead_count')->nullable()->after('monday_timing');
            $table->unsignedInteger('tuesday_lead_count')->nullable()->after('tuesday_timing');
            $table->unsignedInteger('wednesday_lead_count')->nullable()->after('wednesday_timing');
            $table->unsignedInteger('thursday_lead_count')->nullable()->after('thursday_timing');
            $table->unsignedInteger('friday_lead_count')->nullable()->after('friday_timing');
            $table->unsignedInteger('saturday_lead_count')->nullable()->after('saturday_timing');
            $table->unsignedInteger('sunday_lead_count')->nullable()->after('sunday_timing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_timetables', function (Blueprint $table) {
            $table->dropColumn('monday_lead_count');
            $table->dropColumn('tuesday_lead_count');
            $table->dropColumn('wednesday_lead_count');
            $table->dropColumn('thursday_lead_count');
            $table->dropColumn('friday_lead_count');
            $table->dropColumn('saturday_lead_count');
            $table->dropColumn('sunday_lead_count');
        });
    }
}
