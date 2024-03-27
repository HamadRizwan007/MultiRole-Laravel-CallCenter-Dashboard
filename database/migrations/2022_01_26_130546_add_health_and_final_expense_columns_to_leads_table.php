<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthAndFinalExpenseColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->text('quote_interested_in')->nullable()->after('year');
            $table->string('have_active_checking_account')->nullable()->after('quote_interested_in');
            $table->text('can_pay_through')->nullable()->after('have_active_checking_account');
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
            $table->dropColumn('quote_interested_in');
            $table->dropColumn('have_active_checking_account');
            $table->dropColumn('can_pay_through');
        });
    }
}
