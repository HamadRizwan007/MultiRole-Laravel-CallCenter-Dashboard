<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedSmallInteger('status')->default(1)->after('assigned_time');
            $table->text('note')->nullable()->after('status');
            $table->unsignedSmallInteger('payment_status')->default(1)->after('note');
            $table->text('payment_note')->nullable()->after('payment_status');
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
            $table->dropColumn('status');
            $table->dropColumn('note');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_note');
        });
    }
}
