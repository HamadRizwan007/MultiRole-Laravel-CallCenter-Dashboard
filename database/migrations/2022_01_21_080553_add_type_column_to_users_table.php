<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

class AddTypeColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->after('client_id');
            $table->text('view_permissions')->nullable()->after('status');
        });

        $output = new ConsoleOutput();
		try {
            User::role('admin')->update(['type' => 1]);
            User::role('client')->update(['type' => 2]);
            User::role('call center')->update(['type' => 3]);
            User::role('agent')->update(['type' => 4]);
            User::role('client agent')->update(['type' => 5]);
            User::role('client manager')->update(['type' => 6]);
        } catch (\Exception $e){
            $output->writeln($e->getMessage());
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('view_permissions');
        });
    }
}
