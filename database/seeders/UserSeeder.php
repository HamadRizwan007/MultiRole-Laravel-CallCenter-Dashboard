<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('TRUNCATE_ON_SEED')) {
            Schema::disableForeignKeyConstraints();
            User::truncate();
            Schema::enableForeignKeyConstraints();

            DB::statement("ALTER TABLE users AUTO_INCREMENT = 21402;");
        }

        $users = [
            [
                'fname' => 'Administrator',
                'lname' => 'NGS',
                'email' => 'admin@gigabitesoft.com',
                'password' => Hash::make("123456789"),
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 1,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'admin',
            ],
        ];

        $test_users = [
            [
                'created_by_id' => 21402,
                'fname' => 'Center',
                'lname' => 'One',
                'email' => 'center@gigabitesoft.com',
                'password' => Hash::make('123456789'),
                'phone' =>  '+123456789258',
                'center_name' => 'Testing center',
                'address_line' => 'testing address, youtube',
                'city' => 'Columbus',
                'state' => 'Ohio',
                'zip_code' => '43210',
                'country' => 'United States',
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 3,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'call center',
            ],
            [
                'created_by_id' => 21402,
                'fname' => 'Agent',
                'lname' => 'One',
                'email' => 'agent@gigabitesoft.com',
                'password' => Hash::make('123456789'),
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 4,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'agent',
            ],
            [
                'created_by_id' => 21402,
                'fname' => 'Client',
                'lname' => 'One',
                'email' => 'client@gigabitesoft.com',
                'password' => Hash::make('123456789'),
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 2,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'client',
            ],
            [
                'created_by_id' => 21402,
                'fname' => 'Client',
                'lname' => 'Agent',
                'email' => 'client_agent@gigabitesoft.com',
                'password' => Hash::make('123456789'),
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 5,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'client agent',
            ],
            [
                'created_by_id' => 21402,
                'fname' => 'Client',
                'lname' => 'Manager',
                'email' => 'client_manager@gigabitesoft.com',
                'password' => Hash::make('123456789'),
                'status' => 2,
                'ip_address' => '127.0.0.1',
                'type' => 6,
                'api_static_data' => [],
                'api_data_map' => [],
                'api_query_map' => [],
                'role' => 'client manager',
            ],
        ];

        if(env('SEED_TEST_DATA')){
            $users = array_merge($users, $test_users);
        }

        foreach ($users as $user) {
            $user_role = $user['role'] ?? 'standard user';
            unset($user['role']);

            $new_user = User::create($user);
            $new_user->assignRole($user_role);
        }
    }
}
