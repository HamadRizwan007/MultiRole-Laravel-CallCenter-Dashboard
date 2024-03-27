<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalExpenseColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('has_active_ssn')->nullable()->after('condo_built_after_2001');
            $table->string('decision_maker')->nullable()->after('has_active_ssn');
            $table->string('monthly_payment_40_100')->nullable()->after('decision_maker');
            $table->string('any_critical_illness')->nullable()->after('monthly_payment_40_100');
            $table->string('critical_illness')->nullable()->after('any_critical_illness');
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
            $table->dropColumn('has_active_ssn');
            $table->dropColumn('decision_maker');
            $table->dropColumn('monthly_payment_40_100');
            $table->dropColumn('any_critical_illness');
            $table->dropColumn('critical_illness');
        });
    }
}
