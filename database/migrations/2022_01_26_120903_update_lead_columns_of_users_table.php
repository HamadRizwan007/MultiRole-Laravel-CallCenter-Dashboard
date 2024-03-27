<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

class UpdateLeadColumnsOfUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('lead_type')->nullable()->change();
            $table->text('lead_request_type')->nullable()->change();
        });

        $output = new ConsoleOutput();
        try {
            $users = User::role('client')->get();
            foreach ($users as $user){
                $updates = [];
                if($user->lead_type){
                    $updates['lead_type'] = [$user->lead_type];
                }

                if($user->lead_request_type){
                    $updates['lead_request_type'] = [$user->lead_request_type];
                }
                $user->update($updates);
            }
        } catch (\Exception $e) {
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
        //
    }
}
