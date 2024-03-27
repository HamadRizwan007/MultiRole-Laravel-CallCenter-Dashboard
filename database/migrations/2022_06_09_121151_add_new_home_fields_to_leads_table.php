<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewHomeFieldsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('home_built_after_2006')->nullable()->after('can_pay_through');
            $table->string('home_4_miles_away_from_water')->nullable()->after('home_built_after_2006');
            $table->string('condo_built_after_2001')->nullable()->after('home_4_miles_away_from_water');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('home_built_after_2006');
            $table->dropColumn('home_4_miles_away_from_water');
            $table->dropColumn('condo_built_after_2001');
        });
    }
}
