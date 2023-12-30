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
                    'global_setting_manage',
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
                'group_name' => 'SlaughterCustomer',
                'permissions' => [
                    'slaughter_customer_manage',
                    'slaughter_customer_list',
                    'slaughter_customer_view',
                    'slaughter_customer_update',
                    'slaughter_customer_delete',
                    'slaughter_customer_create',
                ]
            ],
            [
                'group_name' => 'SlaughterCustomerReceive',
                'permissions' => [
                    'slaughter_customer_receive_manage',
                    'slaughter_customer_receive_list',
                    'slaughter_customer_receive_view',
                    'slaughter_customer_receive_update',
                    'slaughter_customer_receive_delete',
                    'slaughter_customer_receive_create',
                    'slaughter_customer_receive_approve',
                ]
            ],
            [
                'group_name' => 'SlaughterStore',
                'permissions' => [
                    'slaughter_store_manage',
                    'slaughter_store_list',
                    'slaughter_store_view',
                    'slaughter_store_update',
                    'slaughter_store_delete',
                    'slaughter_store_create',
                ]
            ],
            [
                'group_name' => 'SlaughterSale',
                'permissions' => [
                    'slaughter_sale_manage',
                    'slaughter_sale_list',
                    'slaughter_sale_view',
                    'slaughter_sale_update',
                    'slaughter_sale_delete',
                    'slaughter_sale_create',
                    'slaughter_sale_approve',
                ]
            ],
            [
                'group_name' => 'SlaughterWaste',
                'permissions' => [
                    'slaughter_waste_manage',
                    'slaughter_waste_list',
                    'slaughter_waste_view',
                    'slaughter_waste_update',
                    'slaughter_waste_delete',
                    'slaughter_waste_create',
                    'slaughter_waste_approve',
                ]
            ],
            [
                'group_name' => 'SlaughterStock',
                'permissions' => [
                    'slaughter_stock_manage',
                    'slaughter_stock_list',
                ]
            ],
            [
                'group_name' => 'Slaughter',
                'permissions' => [
                    'slaughter_manage',
                    'slaughter_list',
                    'slaughter_view',
                    'slaughter_update',
                    'slaughter_delete',
                    'slaughter_create',
                    'slaughter_approve',
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
                'group_name' => 'Treatment',
                'permissions' => [
                    'treatment_manage',
                    'treatment_list',
                    'treatment_view',
                    'treatment_update',
                    'treatment_delete',
                    'treatment_create',
                    'treatment_approve',
                ]
            ],
            [
                'group_name' => 'Dewormer',
                'permissions' => [
                    'dewormer_manage',
                    'dewormer_list',
                    'dewormer_view',
                    'dewormer_update',
                    'dewormer_delete',
                    'dewormer_create',
                    'dewormer_approve',
                ]
            ],
            [
                'group_name' => 'Vaccine',
                'permissions' => [
                    'vaccine_manage',
                    'vaccine_list',
                    'vaccine_view',
                    'vaccine_update',
                    'vaccine_delete',
                    'vaccine_create',
                    'vaccine_approve',
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
            [
                'group_name' => 'Accounts',
                'permissions' => [
                    'account_manage',
                    'account_list',
                    'account_view',
                    'account_update',
                    'account_delete',
                    'account_create',
                ]
            ],
            [
                'group_name' => 'Asset',
                'permissions' => [
                    'asset_manage',
                    'asset_list',
                    'asset_view',
                    'asset_update',
                    'asset_approve',
                    'asset_delete',
                    'asset_create',
                ]
            ],
            [
                'group_name' => 'Staff',
                'permissions' => [
                    'staff_manage',
                    'staff_list',
                    'staff_view',
                    'staff_update',
                    'staff_delete',
                    'staff_create',
                ]
            ],
            [
                'group_name' => 'OpeningBalance',
                'permissions' => [
                    'opening_balance_manage',
                    'opening_balance_list',
                    'opening_balance_view',
                    'opening_balance_update',
                    'opening_balance_delete',
                    'opening_balance_create',
                    'opening_balance_approve',
                ]
            ],
            [
                'group_name' => 'BalanceTransfer',
                'permissions' => [
                    'balance_transfer_manage',
                    'balance_transfer_list',
                    'balance_transfer_view',
                    'balance_transfer_update',
                    'balance_transfer_delete',
                    'balance_transfer_create',
                    'balance_transfer_approve',
                ]
            ],
            [
                'group_name' => 'BalanceTransfer',
                'permissions' => [
                    'balance_transfer_manage',
                    'balance_transfer_list',
                    'balance_transfer_view',
                    'balance_transfer_update',
                    'balance_transfer_delete',
                    'balance_transfer_create',
                    'balance_transfer_approve',
                ]
            ],
            [
                'group_name' => 'SupplierPayment',
                'permissions' => [
                    'supplier_payment_manage',
                    'supplier_payment_list',
                    'supplier_payment_view',
                    'supplier_payment_update',
                    'supplier_payment_delete',
                    'supplier_payment_create',
                    'supplier_payment_approve',
                ]
            ],
            [
                'group_name' => 'StaffPayment',
                'permissions' => [
                    'staff_payment_manage',
                    'staff_payment_list',
                    'staff_payment_view',
                    'staff_payment_update',
                    'staff_payment_delete',
                    'staff_payment_create',
                    'staff_payment_approve',
                ]
            ],
            [
                'group_name' => 'PartyReceive',
                'permissions' => [
                    'party_receive_manage',
                    'party_receive_list',
                    'party_receive_view',
                    'party_receive_update',
                    'party_receive_delete',
                    'party_receive_create',
                    'party_receive_approve',
                ]
            ],
            [
                'group_name' => 'ExpenseCategory',
                'permissions' => [
                    'expense_category_manage',
                    'expense_category_list',
                    'expense_category_view',
                    'expense_category_update',
                    'expense_category_delete',
                    'expense_category_create',
                ]
            ],
            [
                'group_name' => 'Expense',
                'permissions' => [
                    'expense_manage',
                    'expense_list',
                    'expense_view',
                    'expense_update',
                    'expense_delete',
                    'expense_create',
                    'expense_approve',
                ]
            ],
            [
                'group_name' => 'CattleDeath',
                'permissions' => [
                    'cattle_death_manage',
                    'cattle_death_list',
                    'cattle_death_view',
                    'cattle_death_update',
                    'cattle_death_delete',
                    'cattle_death_create',
                    'cattle_death_approve',
                ]
            ],
            [
                'group_name' => 'CattleSale',
                'permissions' => [
                    'cattle_sale_manage',
                    'cattle_sale_list',
                    'cattle_sale_view',
                    'cattle_sale_update',
                    'cattle_sale_delete',
                    'cattle_sale_create',
                    'cattle_sale_approve',
                ]
            ],
            [
                'group_name' => 'BulkCattleSale',
                'permissions' => [
                    'bulk_cattle_sale_manage',
                    'bulk_cattle_sale_list',
                    'bulk_cattle_sale_view',
                    'bulk_cattle_sale_update',
                    'bulk_cattle_sale_delete',
                    'bulk_cattle_sale_create',
                    'bulk_cattle_sale_approve',
                ]
            ],
            [
                'group_name' => 'MilkStock',
                'permissions' => [
                    'milk_stock_manage',
                    'milk_stock_list',
                    'milk_stock_view',

                ]
            ],
            [
                'group_name' => 'MilkProduction',
                'permissions' => [
                    'milk_production_manage',
                    'milk_production_list',
                    'milk_production_view',
                    'milk_production_update',
                    'milk_production_delete',
                    'milk_production_create',
                    'milk_production_approve',
                ]
            ],
            [
                'group_name' => 'MilkSale',
                'permissions' => [
                    'milk_sale_manage',
                    'milk_sale_list',
                    'milk_sale_view',
                    'milk_sale_update',
                    'milk_sale_delete',
                    'milk_sale_create',
                    'milk_sale_approve',
                ]
            ],
            [
                'group_name' => 'MilkSaleParty',
                'permissions' => [
                    'milk_sale_party_manage',
                    'milk_sale_party_list',
                    'milk_sale_party_view',
                    'milk_sale_party_update',
                    'milk_sale_party_delete',
                    'milk_sale_party_create',
                    'milk_sale_party_approve',
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
