<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds_
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        Role::create(['name' => 'user']);
        $permissions = [
            [
                'group_name' => 'Global',
                'permissions' => [
                    'dashboard_manage',
                    'site_setting_manage',
                    'inventory_manage',
                ]
            ],
            [
                'group_name' => 'Commands',
                'permissions' => [
                    'commands_manage',
                    'command_cache_clear',
                    'command_config_clear',
                    'command_route_clear',
                    'command_optimize',
                    'command_migrate',
                    'command_migrate_fresh',
                    'command_migrate_fresh_seed',
                ]
            ],
            [
                'group_name' => 'Roles',
                'permissions' => [
                    'role_manage',
                    'role_list',
                    'role_view',
                    'role_create',
                    'role_update',
                    'role_delete',
                ]
            ],
            [
                'group_name' => 'Permission',
                'permissions' => [
                    'permission_manage',
                    'permission_list',
                    'permission_view',
                    'permission_update',
                    'permission_delete',
                    'permission_create',

                ]
            ],
            [
                'group_name' => 'Admin',
                'permissions' => [
                    'admin_manage',
                    'admin_list',
                    'admin_view',
                    'admin_update',
                    'admin_delete',
                    'admin_create',
                ]
            ],
            [
                'group_name' => 'Supplier',
                'permissions' => [
                    'supplier_manage',
                    'supplier_list',
                    'supplier_view',
                    'supplier_update',
                    'supplier_delete',
                    'supplier_create',
                ]
            ],
            [
                'group_name' => 'CattleType',
                'permissions' => [
                    'cattle_type_manage',
                    'cattle_type_list',
                    'cattle_type_view',
                    'cattle_type_update',
                    'cattle_type_delete',
                    'cattle_type_create',
                ]
            ],
            [
                'group_name' => 'SessionYear',
                'permissions' => [
                    'session_year_manage',
                    'session_year_list',
                    'session_year_view',
                    'session_year_update',
                    'session_year_delete',
                    'session_year_create',
                ]
            ],
            [
                'group_name' => 'Batches',
                'permissions' => [
                    'batch_manage',
                    'batch_list',
                    'batch_view',
                    'batch_update',
                    'batch_delete',
                    'batch_create',
                ]
            ],
            [
                'group_name' => 'Breeds',
                'permissions' => [
                    'breed_manage',
                    'breed_list',
                    'breed_view',
                    'breed_update',
                    'breed_delete',
                    'breed_create',
                ]
            ],
            [
                'group_name' => 'Farms',
                'permissions' => [
                    'farm_manage',
                    'farm_list',
                    'farm_view',
                    'farm_update',
                    'farm_delete',
                    'farm_create',
                ]
            ],
            [
                'group_name' => 'Cattle',
                'permissions' => [
                    'cattle_manage',
                    'cattle_list',
                    'cattle_view',
                    'cattle_update',
                    'cattle_delete',
                    'cattle_create',
                ]
            ],
            [
                'group_name' => 'CattleStructure',
                'permissions' => [
                    'cattle_structure_manage',
                    'cattle_structure_list',
                    'cattle_structure_view',
                    'cattle_structure_update',
                    'cattle_structure_delete',
                    'cattle_structure_create',
                ]
            ],
            [
                'group_name' => 'Unit',
                'permissions' => [
                    'unit_manage',
                    'unit_list',
                    'unit_view',
                    'unit_update',
                    'unit_delete',
                    'unit_create',
                ]
            ],
            [
                'group_name' => 'Product',
                'permissions' => [
                    'product_manage',
                    'product_list',
                    'product_view',
                    'product_update',
                    'product_delete',
                    'product_create',
                ]
            ],
            [
                'group_name' => 'Tax',
                'permissions' => [
                    'tax_manage',
                    'tax_list',
                    'tax_view',
                    'tax_update',
                    'tax_delete',
                    'tax_create',
                ]
            ],


        ];

        for ($i = 0;$i<count($permissions);$i++){
            $permissions_group = $permissions[$i]['group_name'];
            for ($j = 0;$j<count($permissions[$i]['permissions']);$j++){
                //Admin guard Permisson
                $super_permission =  Permission::create(['name'=>$permissions[$i]['permissions'][$j],'group_name'=>$permissions_group]);
                $superAdmin->givePermissionTo($super_permission);
                $super_permission->assignRole($superAdmin);

            }

        }
    }
}
