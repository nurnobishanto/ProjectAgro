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
        $superAdmin = Role::where('name','super_admin')->first();
        if (!$superAdmin){
            $superAdmin = Role::create(['name' => 'super_admin']);
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'employee']);
            Role::create(['name' => 'user']);
        }
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
                    'command_seed',
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
                'group_name' => 'Party',
                'permissions' => [
                    'party_manage',
                    'party_list',
                    'party_view',
                    'party_update',
                    'party_delete',
                    'party_create',
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
                'group_name' => 'Fattening',
                'permissions' => [
                    'fattening_manage',
                    'fattening_list',
                    'fattening_view',
                    'fattening_update',
                    'fattening_delete',
                    'fattening_create',
                ]
            ],
            [
                'group_name' => 'Feeding',
                'permissions' => [
                    'feeding_manage',
                    'feeding_list',
                    'feeding_view',
                    'feeding_update',
                    'feeding_delete',
                    'feeding_create',
                    'feeding_approve',
                ]
            ],
            [
                'group_name' => 'FeedingGroup',
                'permissions' => [
                    'feeding_group_manage',
                    'feeding_group_list',
                    'feeding_group_view',
                    'feeding_group_update',
                    'feeding_group_delete',
                    'feeding_group_create',
                ]
            ],
            [
                'group_name' => 'FeedingCategory',
                'permissions' => [
                    'feeding_category_manage',
                    'feeding_category_list',
                    'feeding_category_view',
                    'feeding_category_update',
                    'feeding_category_delete',
                    'feeding_category_create',
                ]
            ],
            [
                'group_name' => 'FeedingMoment',
                'permissions' => [
                    'feeding_moment_manage',
                    'feeding_moment_list',
                    'feeding_moment_view',
                    'feeding_moment_update',
                    'feeding_moment_delete',
                    'feeding_moment_create',
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
            [
                'group_name' => 'Purchase',
                'permissions' => [
                    'purchase_manage',
                    'purchase_list',
                    'purchase_view',
                    'purchase_update',
                    'purchase_delete',
                    'purchase_create',
                    'purchase_approve',
                ]
            ],
            [
                'group_name' => 'StockReport',
                'permissions' => [
                    'stock_manage',
                    'stock_list',
                    'stock_view',
                    'stock_update',
                    'stock_delete',
                    'stock_create',
                ]
            ],


        ];

        for ($i = 0;$i<count($permissions);$i++){
            $permissions_group = $permissions[$i]['group_name'];
            for ($j = 0;$j<count($permissions[$i]['permissions']);$j++){
                $super_permission = Permission::where('name',$permissions[$i]['permissions'][$j])->first();
                if (!$super_permission){
                    $super_permission =  Permission::create(['name'=>$permissions[$i]['permissions'][$j],'group_name'=>$permissions_group]);
                }
                $superAdmin->givePermissionTo($super_permission);
                $super_permission->assignRole($superAdmin);

            }

        }
    }
}
