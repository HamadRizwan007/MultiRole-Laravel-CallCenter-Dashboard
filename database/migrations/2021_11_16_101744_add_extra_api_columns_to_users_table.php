<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraApiColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedMediumInteger('api_type')->nullable()->before('api_url');
            $table->string('api_return_id_column', 255)->nullable()->before('api_type');
            $table->longText('api_static_data')->nullable()->after('api_return_id_column');
            $table->longText('api_data_map')->nullable()->after('api_static_data');
            $table->longText('api_query_map')->nullable()->after('api_data_map');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('api_type');
            $table->dropColumn('api_return_id_column');
            $table->dropColumn('api_static_data');
            $table->dropColumn('api_data_map');
            $table->dropColumn('api_query_map');
        });
    }
}
