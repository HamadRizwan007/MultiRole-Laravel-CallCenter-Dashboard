<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        if(config('app.debug')) {
            Schema::disableForeignKeyConstraints();
            DB::table('roles')->truncate();
            DB::table('role_has_permissions')->truncate();
            DB::table('permissions')->truncate();
            // DB::table('model_has_roles')->truncate();
            // DB::table('model_has_permissions')->truncate();
            Schema::enableForeignKeyConstraints();
        }

        $permissionsByRole  = [
            'admin' => [
                'view dashboard',
                'view all users',
                'create centers',
                'update center info',
                'update centers password',
                'delete center',
                'create agents',
                'update agent info',
                'update agents password',
                'update agent center',
                'delete agent',
                'create clients',
                'update client info',
                'update clients password',
                'update client center',
                'delete client',
                'create client agents',
                'update client agent info',
                'update client agents password',
                'update client agent client',
                'delete client agent',
                'create client managers',
                'update client manager info',
                'update client managers password',
                'update client manager client',
                'delete client manager',
                'attach client to lead',
                'create client broker',
                'update client broker info',
                'view all leads',
                'view own leads',
                'create leads',
                'assign leads',
                'update leads',
                'delete leads',
                'view all tickets',
                'update tickets',
                'delete tickets',
                'view all agreement',
                'view shared agreement',
                'create agreement',
                'download agreement',
                'delete agreement',
                'view all document',
                'download document',
                'delete document',
            ],
            'call center' => [
                'view dashboard',
                'create agents',
                'update agent info',
                'update agents password',
                'delete agent',
                'attach client to lead',
                'view center leads',
                'create leads',
                'view own leads',
                'assign leads',
                'update leads',
                'delete leads',
                'create tickets',
                'view own tickets',
                'view shared agreement',
                'download agreement',
                'accept agreement',
                'view personal document',
                'create document',
                'download document',
            ],
            'agent' => [
                'view dashboard',
                'view personal leads',
                'create leads',
                'attach client to lead',
                'view own leads',
                'assign leads',
                'update leads',
                'delete leads',
                'create tickets',
                'view own tickets',
            ],
            'client' => [
                'view dashboard',
                'view assigned leads',
                'create tickets',
                'view own tickets',
                'create client agents',
                'update client agent info',
                'update client agents password',
                'update client agent client',
                'delete client agent',
                'create client managers',
                'update client manager info',
                'update client managers password',
                'update client manager client',
                'delete client manager',
                'view shared agreement',
                'download agreement',
                'accept agreement',
                'view personal document',
                'create document',
                'download document',
            ],
            'client agent' => [
                'view dashboard',
                'view client leads',
                'create tickets',
                'view own tickets',
            ],
            'client manager' => [
                'view dashboard',
                'view client leads',
                'create tickets',
                'view own tickets',
                'create client agents',
                'update client agent info',
                'update client agents password',
                'update client agent client',
                'delete client agent',
                'view shared agreement',
                'download agreement',
                'view personal document',
                'create document',
                'download document',
            ],
            'client broker' => [
                'view dashboard',
                'view assigned leads',
                'create clients',
                'update client info',
                'update clients password',
                'update client center',
                'delete client',
                'create client agents',
                'update client agent info',
                'update client agents password',
                'update client agent client',
                'delete client agent',
                'create client managers',
                'update client manager info',
                'update client managers password',
                'update client manager client',
                'delete client manager',
                'create tickets',
                'view own tickets',
                'view shared agreement',
                'download agreement',
                'accept agreement',
                'view personal document',
                'create document',
                'download document',
            ],
        ];

        $insertPermissions = function ($role) use ($permissionsByRole) {
            return collect($permissionsByRole[$role])
                ->map(function ($name) {
                    return (Permission::findOrCreate($name))->id;
                })
                ->toArray();
        };

        $permissionIdsByRole = [
            'admin' => $insertPermissions('admin'),
            'call center' => $insertPermissions('call center'),
            'agent' => $insertPermissions('agent'),
            'client' => $insertPermissions('client'),
            'client agent' => $insertPermissions('client agent'),
            'client manager' => $insertPermissions('client manager'),
            'client broker' => $insertPermissions('client broker'),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::findOrCreate($role);

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(function ($id) use ($role) {
                        return [
                            'role_id' => $role->id,
                            'permission_id' => $id
                        ];
                    })->toArray()
                );
        }
    }
}
