<?php


use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\BalanceTransferController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BreedsController;
use App\Http\Controllers\Admin\BulkCattleSaleController;
use App\Http\Controllers\Admin\CattleController;
use App\Http\Controllers\Admin\CattleDeathController;
use App\Http\Controllers\Admin\CattleSaleController;
use App\Http\Controllers\Admin\CattleTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FarmController;
use App\Http\Controllers\Admin\FatteningController;
use App\Http\Controllers\Admin\FeedingCategoryController;
use App\Http\Controllers\Admin\FeedingController;
use App\Http\Controllers\Admin\DewormerController;
use App\Http\Controllers\Admin\FeedingGroupController;
use App\Http\Controllers\Admin\FeedingMomentController;
use App\Http\Controllers\Admin\OpeningBalanceController;
use App\Http\Controllers\Admin\PartyController;
use App\Http\Controllers\Admin\PartyReceivedController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SessionYearController;
use App\Http\Controllers\Admin\SlaughterController;
use App\Http\Controllers\Admin\SlaughterCustomerController;
use App\Http\Controllers\Admin\SlaughterCustomerReceiveController;
use App\Http\Controllers\Admin\SlaughterSaleController;
use App\Http\Controllers\Admin\SlaughterStoreController;
use App\Http\Controllers\Admin\SlaughterWasteController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffPaymentController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierPaymentController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VaccineController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:role_manage');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permission_manage');

//Admin
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])->middleware('permission:admin_manage')->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])->middleware('permission:admin_manage')->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])->middleware('permission:admin_manage')->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admin_manage');

//Profile
Route::get('/profile',[AdminController::class,'profile'])->name('profile');
Route::post('/profile',[AdminController::class,'profile_update'])->name('profile_update');

//Suppliers
Route::get('/suppliers/trashed',[SupplierController::class,'trashed_list'])->middleware('permission:supplier_manage')->name('suppliers.trashed');
Route::get('/suppliers/trashed/{supplier}/restore',[SupplierController::class,'restore'])->middleware('permission:supplier_manage')->name('suppliers.restore');
Route::get('/suppliers/trashed/{supplier}/delete',[SupplierController::class,'force_delete'])->middleware('permission:supplier_manage')->name('suppliers.force_delete');
Route::resource('/suppliers',SupplierController::class)->middleware('permission:supplier_manage');

//Party
Route::get('/parties/trashed',[PartyController::class,'trashed_list'])->middleware('permission:party_manage')->name('parties.trashed');
Route::get('/parties/trashed/{party}/restore',[PartyController::class,'restore'])->middleware('permission:party_manage')->name('parties.restore');
Route::get('/parties/trashed/{party}/delete',[PartyController::class,'force_delete'])->middleware('permission:party_manage')->name('parties.force_delete');
Route::resource('/parties',PartyController::class)->middleware('permission:party_manage');

//Slaughter Customers
Route::get('/slaughter-customers/trashed',[SlaughterCustomerController::class,'trashed_list'])->middleware('permission:slaughter_customer_manage')->name('slaughter-customers.trashed');
Route::get('/slaughter-customers/trashed/{slaughter_customer}/restore',[SlaughterCustomerController::class,'restore'])->middleware('permission:slaughter_customer_manage')->name('slaughter-customers.restore');
Route::get('/slaughter-customers/trashed/{slaughter_customer}/delete',[SlaughterCustomerController::class,'force_delete'])->middleware('permission:slaughter_customer_manage')->name('slaughter-customers.force_delete');
Route::resource('/slaughter-customers',SlaughterCustomerController::class)->middleware('permission:slaughter_customer_manage');

//Slaughter Store
Route::get('/slaughter-stores/trashed',[SlaughterStoreController::class,'trashed_list'])->middleware('permission:slaughter_store_manage')->name('slaughter-stores.trashed');
Route::get('/slaughter-stores/trashed/{slaughter_store}/restore',[SlaughterStoreController::class,'restore'])->middleware('permission:slaughter_store_manage')->name('slaughter-stores.restore');
Route::get('/slaughter-stores/trashed/{slaughter_store}/delete',[SlaughterStoreController::class,'force_delete'])->middleware('permission:slaughter_store_manage')->name('slaughter-stores.force_delete');
Route::resource('/slaughter-stores',SlaughterStoreController::class)->middleware('permission:slaughter_store_manage');


//Cattle Type
Route::get('/cattle-types/trashed',[CattleTypeController::class,'trashed_list'])->middleware('permission:cattle_type_manage')->name('cattle-types.trashed');
Route::get('/cattle-types/trashed/{cattle_type}/restore',[CattleTypeController::class,'restore'])->middleware('permission:cattle_type_manage')->name('cattle-types.restore');
Route::get('/cattle-types/trashed/{cattle_type}/delete',[CattleTypeController::class,'force_delete'])->middleware('permission:cattle_type_manage')->name('cattle-types.force_delete');
Route::resource('/cattle-types',CattleTypeController::class)->middleware('permission:cattle_type_manage');

//Session year
Route::get('/session-years/trashed',[SessionYearController::class,'trashed_list'])->middleware('permission:session_year_manage')->name('session-years.trashed');
Route::get('/session-years/trashed/{session_year}/restore',[SessionYearController::class,'restore'])->middleware('permission:session_year_manage')->name('session-years.restore');
Route::get('/session-years/trashed/{session_year}/delete',[SessionYearController::class,'force_delete'])->middleware('permission:session_year_manage')->name('session-years.force_delete');
Route::resource('/session-years',SessionYearController::class)->middleware('permission:session_year_manage');

//Batch
Route::get('/batches/trashed',[BatchController::class,'trashed_list'])->middleware('permission:batch_manage')->name('batches.trashed');
Route::get('/batches/trashed/{batch}/restore',[BatchController::class,'restore'])->middleware('permission:batch_manage')->name('batches.restore');
Route::get('/batches/trashed/{batch}/delete',[BatchController::class,'force_delete'])->middleware('permission:batch_manage')->name('batches.force_delete');
Route::resource('/batches',BatchController::class)->middleware('permission:batch_manage');

//Breed
Route::get('/breeds/trashed',[BreedsController::class,'trashed_list'])->middleware('permission:breed_manage')->name('breeds.trashed');
Route::get('/breeds/trashed/{breed}/restore',[BreedsController::class,'restore'])->middleware('permission:breed_manage')->name('breeds.restore');
Route::get('/breeds/trashed/{breed}/delete',[BreedsController::class,'force_delete'])->middleware('permission:breed_manage')->name('breeds.force_delete');
Route::resource('/breeds',BreedsController::class)->middleware('permission:breed_manage');

//Farm
Route::get('/farms/trashed',[FarmController::class,'trashed_list'])->middleware('permission:farm_manage')->name('farms.trashed');
Route::get('/farms/trashed/{farm}/restore',[FarmController::class,'restore'])->middleware('permission:farm_manage')->name('farms.restore');
Route::get('/farms/trashed/{farm}/delete',[FarmController::class,'force_delete'])->middleware('permission:farm_manage')->name('farms.force_delete');
Route::resource('/farms',FarmController::class)->middleware('permission:farm_manage');

//Cattle Listing
Route::get('/cattles/trashed',[CattleController::class,'trashed_list'])->middleware('permission:cattle_manage')->name('cattles.trashed');
Route::get('/cattles/trashed/{cattle}/restore',[CattleController::class,'restore'])->middleware('permission:cattle_manage')->name('cattles.restore');
Route::get('/cattles/trashed/{cattle}/delete',[CattleController::class,'force_delete'])->middleware('permission:cattle_manage')->name('cattles.force_delete');
Route::resource('/cattles',CattleController::class)->middleware('permission:cattle_manage');

//Unit
Route::get('/units/trashed',[UnitController::class,'trashed_list'])->middleware('permission:unit_manage')->name('units.trashed');
Route::get('/units/trashed/{unit}/restore',[UnitController::class,'restore'])->middleware('permission:unit_manage')->name('units.restore');
Route::get('/units/trashed/{unit}/delete',[UnitController::class,'force_delete'])->middleware('permission:unit_manage')->name('units.force_delete');
Route::resource('/units',UnitController::class)->middleware('permission:unit_manage');

//Product
Route::get('/products/trashed',[ProductController::class,'trashed_list'])->middleware('permission:product_manage')->name('products.trashed');
Route::get('/products/trashed/{product}/restore',[ProductController::class,'restore'])->middleware('permission:product_manage')->name('products.restore');
Route::get('/products/trashed/{product}/delete',[ProductController::class,'force_delete'])->middleware('permission:product_manage')->name('products.force_delete');
Route::resource('/products',ProductController::class)->middleware('permission:product_manage');

//Vat
Route::get('/taxes/trashed',[TaxController::class,'trashed_list'])->middleware('permission:tax_manage')->name('taxes.trashed');
Route::get('/taxes/trashed/{tax}/restore',[TaxController::class,'restore'])->middleware('permission:tax_manage')->name('taxes.restore');
Route::get('/taxes/trashed/{tax}/delete',[TaxController::class,'force_delete'])->middleware('permission:tax_manage')->name('taxes.force_delete');
Route::resource('/taxes',TaxController::class)->middleware('permission:tax_manage');

//Fattening
Route::resource('/fattenings',FatteningController::class)->middleware('permission:fattening_manage');

//Purchase
Route::get('/purchases/trashed',[PurchaseController::class,'trashed_list'])->middleware('permission:purchase_manage')->name('purchases.trashed');
Route::get('/purchases/trashed/{purchase}/restore',[PurchaseController::class,'restore'])->middleware('permission:purchase_manage')->name('purchases.restore');
Route::get('/purchases/trashed/{purchase}/delete',[PurchaseController::class,'force_delete'])->middleware('permission:purchase_manage')->name('purchases.force_delete');
Route::post('/purchases/{purchase}/approve',[PurchaseController::class,'approve'])->middleware('permission:purchase_approve')->name('purchases.approve');
Route::resource('/purchases',PurchaseController::class)->middleware('permission:purchase_manage');
Route::get('/stock',[PurchaseController::class,'stock'])->middleware('permission:stock_manage')->name('stock');

//Feeding Category
Route::get('/feeding-categories/trashed',[FeedingCategoryController::class,'trashed_list'])->middleware('permission:feeding_category_manage')->name('feeding-categories.trashed');
Route::get('/feeding-categories/trashed/{feeding_category}/restore',[FeedingCategoryController::class,'restore'])->middleware('permission:feeding_category_manage')->name('feeding-categories.restore');
Route::get('/feeding-categories/trashed/{feeding_category}/delete',[FeedingCategoryController::class,'force_delete'])->middleware('permission:feeding_category_manage')->name('feeding-categories.force_delete');
Route::resource('/feeding-categories',FeedingCategoryController::class)->middleware('permission:feeding_category_manage');

//Feeding Moment
Route::get('/feeding-moments/trashed',[FeedingMomentController::class,'trashed_list'])->middleware('permission:feeding_moment_manage')->name('feeding-moments.trashed');
Route::get('/feeding-moments/trashed/{feeding_moment}/restore',[FeedingMomentController::class,'restore'])->middleware('permission:feeding_moment_manage')->name('feeding-moments.restore');
Route::get('/feeding-moments/trashed/{feeding_moment}/delete',[FeedingMomentController::class,'force_delete'])->middleware('permission:feeding_moment_manage')->name('feeding-moments.force_delete');
Route::resource('/feeding-moments',FeedingMomentController::class)->middleware('permission:feeding_moment_manage');

//Feeding Group
Route::get('/feeding-groups/trashed',[FeedingGroupController::class,'trashed_list'])->middleware('permission:feeding_group_manage')->name('feeding-groups.trashed');
Route::get('/feeding-groups/trashed/{feeding_group}/restore',[FeedingGroupController::class,'restore'])->middleware('permission:feeding_group_manage')->name('feeding-groups.restore');
Route::get('/feeding-groups/trashed/{feeding_group}/delete',[FeedingGroupController::class,'force_delete'])->middleware('permission:feeding_group_manage')->name('feeding-groups.force_delete');
Route::resource('/feeding-groups',FeedingGroupController::class)->middleware('permission:feeding_group_manage');

//Feeding Group
Route::get('/feedings/trashed',[FeedingController::class,'trashed_list'])->middleware('permission:feeding_manage')->name('feedings.trashed');
Route::get('/feedings/trashed/{feeding}/restore',[FeedingController::class,'restore'])->middleware('permission:feeding_manage')->name('feedings.restore');
Route::get('/feedings/trashed/{feeding}/delete',[FeedingController::class,'force_delete'])->middleware('permission:feeding_manage')->name('feedings.force_delete');
Route::get('/feedings/{feeding}/approve',[FeedingController::class,'approve'])->middleware('permission:feeding_approve')->name('feedings.approve');
Route::resource('/feedings',FeedingController::class)->middleware('permission:feeding_manage');

//Feeding Dewormer
Route::get('/dewormers/trashed',[DewormerController::class,'trashed_list'])->middleware('permission:dewormer_manage')->name('dewormers.trashed');
Route::get('/dewormers/trashed/{dewormer}/restore',[DewormerController::class,'restore'])->middleware('permission:dewormer_manage')->name('dewormers.restore');
Route::get('/dewormers/trashed/{dewormer}/delete',[DewormerController::class,'force_delete'])->middleware('permission:dewormer_manage')->name('dewormers.force_delete');
Route::get('/dewormers/{dewormer}/approve',[DewormerController::class,'approve'])->middleware('permission:dewormer_approve')->name('dewormers.approve');
Route::resource('/dewormers',DewormerController::class)->middleware('permission:dewormer_manage');

//Feeding Vaccine
Route::get('/vaccines/trashed',[VaccineController::class,'trashed_list'])->middleware('permission:vaccine_manage')->name('vaccines.trashed');
Route::get('/vaccines/trashed/{vaccine}/restore',[VaccineController::class,'restore'])->middleware('permission:vaccine_manage')->name('vaccines.restore');
Route::get('/vaccines/trashed/{vaccine}/delete',[VaccineController::class,'force_delete'])->middleware('permission:vaccine_manage')->name('vaccines.force_delete');
Route::get('/vaccines/{vaccine}/approve',[VaccineController::class,'approve'])->middleware('permission:vaccine_approve')->name('vaccines.approve');
Route::resource('/vaccines',VaccineController::class)->middleware('permission:vaccine_manage');

//Feeding Treatment
Route::get('/treatments/trashed',[TreatmentController::class,'trashed_list'])->middleware('permission:treatment_manage')->name('treatments.trashed');
Route::get('/treatments/trashed/{treatment}/restore',[TreatmentController::class,'restore'])->middleware('permission:treatment_manage')->name('treatments.restore');
Route::get('/treatments/trashed/{treatment}/delete',[TreatmentController::class,'force_delete'])->middleware('permission:treatment_manage')->name('treatments.force_delete');
Route::get('/treatments/{treatment}/approve',[TreatmentController::class,'approve'])->middleware('permission:treatment_approve')->name('treatments.approve');
Route::resource('/treatments',TreatmentController::class)->middleware('permission:treatment_manage');


//Accounts
Route::get('/accounts/trashed',[AccountController::class,'trashed_list'])->middleware('permission:account_manage')->name('accounts.trashed');
Route::get('/accounts/trashed/{account}/restore',[AccountController::class,'restore'])->middleware('permission:account_manage')->name('accounts.restore');
Route::get('/accounts/trashed/{account}/delete',[AccountController::class,'force_delete'])->middleware('permission:account_manage')->name('accounts.force_delete');
Route::resource('/accounts',AccountController::class)->middleware('permission:account_manage');

//Assets
Route::get('/assets/trashed',[AssetController::class,'trashed_list'])->middleware('permission:asset_manage')->name('assets.trashed');
Route::get('/assets/trashed/{asset}/restore',[AssetController::class,'restore'])->middleware('permission:asset_manage')->name('assets.restore');
Route::get('/assets/trashed/{asset}/delete',[AssetController::class,'force_delete'])->middleware('permission:asset_manage')->name('assets.force_delete');
Route::get('/assets/{asset}/approve',[AssetController::class,'approve'])->middleware('permission:asset_approve')->name('assets.approve');
Route::resource('/assets',AssetController::class)->middleware('permission:asset_manage');

//Staff
Route::get('/staffs/trashed',[StaffController::class,'trashed_list'])->middleware('permission:staff_manage')->name('staffs.trashed');
Route::get('/staffs/trashed/{staff}/restore',[StaffController::class,'restore'])->middleware('permission:staff_manage')->name('staffs.restore');
Route::get('/staffs/trashed/{staff}/delete',[StaffController::class,'force_delete'])->middleware('permission:staff_manage')->name('staffs.force_delete');
Route::resource('/staffs',StaffController::class)->middleware('permission:staff_manage');


//Opening Balance
Route::get('/opening-balances/trashed',[OpeningBalanceController::class,'trashed_list'])->middleware('permission:opening_balance_manage')->name('opening-balances.trashed');
Route::get('/opening-balances/trashed/{opening_balance}/restore',[OpeningBalanceController::class,'restore'])->middleware('permission:opening_balance_manage')->name('opening-balances.restore');
Route::get('/opening-balances/trashed/{opening_balance}/delete',[OpeningBalanceController::class,'force_delete'])->middleware('permission:opening_balance_manage')->name('opening-balances.force_delete');
Route::get('/opening-balances/{opening_balance}/approve',[OpeningBalanceController::class,'approve'])->middleware('permission:opening_balance_approve')->name('opening-balances.approve');
Route::resource('/opening-balances',OpeningBalanceController::class)->middleware('permission:opening_balance_manage');

//Balance Transfer
Route::get('/balance-transfers/trashed',[BalanceTransferController::class,'trashed_list'])->middleware('permission:balance_transfer_manage')->name('balance-transfers.trashed');
Route::get('/balance-transfers/trashed/{balance_transfer}/restore',[BalanceTransferController::class,'restore'])->middleware('permission:balance_transfer_manage')->name('balance-transfers.restore');
Route::get('/balance-transfers/trashed/{balance_transfer}/delete',[BalanceTransferController::class,'force_delete'])->middleware('permission:balance_transfer_manage')->name('balance-transfers.force_delete');
Route::get('/balance-transfers/{balance_transfer}/approve',[BalanceTransferController::class,'approve'])->middleware('permission:balance_transfer_approve')->name('balance-transfers.approve');
Route::resource('/balance-transfers',BalanceTransferController::class)->middleware('permission:balance_transfer_manage');


//ExpenseCategory
Route::get('/expense-categories/trashed',[ExpenseCategoryController::class,'trashed_list'])->middleware('permission:expense_category_manage')->name('expense-categories.trashed');
Route::get('/expense-categories/trashed/{expense_category}/restore',[ExpenseCategoryController::class,'restore'])->middleware('permission:expense_category_manage')->name('expense-categories.restore');
Route::get('/expense-categories/trashed/{expense_category}/delete',[ExpenseCategoryController::class,'force_delete'])->middleware('permission:expense_category_manage')->name('expense-categories.force_delete');
Route::resource('/expense-categories',ExpenseCategoryController::class)->middleware('permission:expense_category_manage');

//Expense
Route::get('/expenses/trashed',[ExpenseController::class,'trashed_list'])->middleware('permission:expense_manage')->name('expenses.trashed');
Route::get('/expenses/trashed/{expense}/restore',[ExpenseController::class,'restore'])->middleware('permission:expense_manage')->name('expenses.restore');
Route::get('/expenses/trashed/{expense}/delete',[ExpenseController::class,'force_delete'])->middleware('permission:expense_manage')->name('expenses.force_delete');
Route::get('/expenses/{expense}/approve',[ExpenseController::class,'approve'])->middleware('permission:expense_approve')->name('expenses.approve');
Route::resource('/expenses',ExpenseController::class)->middleware('permission:expense_manage');

//CattleDeath
Route::get('/cattle-deaths/trashed',[CattleDeathController::class,'trashed_list'])->middleware('permission:cattle_death_manage')->name('cattle-deaths.trashed');
Route::get('/cattle-deaths/trashed/{cattle_death}/restore',[CattleDeathController::class,'restore'])->middleware('permission:cattle_death_manage')->name('cattle-deaths.restore');
Route::get('/cattle-deaths/trashed/{cattle_death}/delete',[CattleDeathController::class,'force_delete'])->middleware('permission:cattle_death_manage')->name('cattle-deaths.force_delete');
Route::get('/cattle-deaths/{cattle_death}/approve',[CattleDeathController::class,'approve'])->middleware('permission:cattle_death_approve')->name('cattle-deaths.approve');
Route::resource('/cattle-deaths',CattleDeathController::class)->middleware('permission:cattle_death_manage');

//CattleSale
Route::get('/cattle-sales/trashed',[CattleSaleController::class,'trashed_list'])->middleware('permission:cattle_sale_manage')->name('cattle-sales.trashed');
Route::get('/cattle-sales/trashed/{cattle_sale}/restore',[CattleSaleController::class,'restore'])->middleware('permission:cattle_sale_manage')->name('cattle-sales.restore');
Route::get('/cattle-sales/trashed/{cattle_sale}/delete',[CattleSaleController::class,'force_delete'])->middleware('permission:cattle_sale_manage')->name('cattle-sales.force_delete');
Route::get('/cattle-sales/{cattle_sale}/approve',[CattleSaleController::class,'approve'])->middleware('permission:cattle_sale_approve')->name('cattle-sales.approve');
Route::resource('/cattle-sales',CattleSaleController::class)->middleware('permission:cattle_sale_manage');

//Slaughter
Route::get('/slaughters/trashed',[SlaughterController::class,'trashed_list'])->middleware('permission:slaughter_manage')->name('slaughters.trashed');
Route::get('/slaughters/trashed/{slaughter}/restore',[SlaughterController::class,'restore'])->middleware('permission:slaughter_manage')->name('slaughters.restore');
Route::get('/slaughters/trashed/{slaughter}/delete',[SlaughterController::class,'force_delete'])->middleware('permission:slaughter_manage')->name('slaughters.force_delete');
Route::get('/slaughters/{slaughter}/approve',[SlaughterController::class,'approve'])->middleware('permission:slaughter_approve')->name('slaughters.approve');
Route::resource('/slaughters',SlaughterController::class)->middleware('permission:slaughter_manage');
Route::get('/slaughter-stocks',[SlaughterController::class,'stocks'])->middleware('permission:slaughter_stock_manage')->name('slaughters.stock');

//BulkCattleSale
Route::get('/bulk-cattle-sales/trashed',[BulkCattleSaleController::class,'trashed_list'])->middleware('permission:bulk_cattle_sale_manage')->name('bulk-cattle-sales.trashed');
Route::get('/bulk-cattle-sales/trashed/{bulk_cattle_sale}/restore',[BulkCattleSaleController::class,'restore'])->middleware('permission:bulk_cattle_sale_manage')->name('bulk-cattle-sales.restore');
Route::get('/bulk-cattle-sales/trashed/{bulk_cattle_sale}/delete',[BulkCattleSaleController::class,'force_delete'])->middleware('permission:bulk_cattle_sale_manage')->name('bulk-cattle-sales.force_delete');
Route::get('/bulk-cattle-sales/{bulk_cattle_sale}/approve',[BulkCattleSaleController::class,'approve'])->middleware('permission:bulk_cattle_sale_approve')->name('bulk-cattle-sales.approve');
Route::resource('/bulk-cattle-sales',BulkCattleSaleController::class)->middleware('permission:bulk_cattle_sale_manage');


//Supplier Payment
Route::get('/supplier-payments/trashed',[SupplierPaymentController::class,'trashed_list'])->middleware('permission:supplier_payment_manage')->name('supplier-payments.trashed');
Route::get('/supplier-payments/trashed/{supplier_payment}/restore',[SupplierPaymentController::class,'restore'])->middleware('permission:supplier_payment_manage')->name('supplier-payments.restore');
Route::get('/supplier-payments/trashed/{supplier_payment}/delete',[SupplierPaymentController::class,'force_delete'])->middleware('permission:supplier_payment_manage')->name('supplier-payments.force_delete');
Route::get('/supplier-payments/{supplier_payment}/approve',[SupplierPaymentController::class,'approve'])->middleware('permission:supplier_payment_approve')->name('supplier-payments.approve');
Route::resource('/supplier-payments',SupplierPaymentController::class)->middleware('permission:supplier_payment_manage');

//Party Receive
Route::get('/party-receives/trashed',[PartyReceivedController::class,'trashed_list'])->middleware('permission:party_receive_manage')->name('party-receives.trashed');
Route::get('/party-receives/trashed/{party_receive}/restore',[PartyReceivedController::class,'restore'])->middleware('permission:party_receive_manage')->name('party-receives.restore');
Route::get('/party-receives/trashed/{party_receive}/delete',[PartyReceivedController::class,'force_delete'])->middleware('permission:party_receive_manage')->name('party-receives.force_delete');
Route::get('/party-receives/{party_receive}/approve',[PartyReceivedController::class,'approve'])->middleware('permission:party_receive_approve')->name('party-receives.approve');
Route::resource('/party-receives',PartyReceivedController::class)->middleware('permission:party_receive_manage');

//Slaughter Customer Receive
Route::get('/slaughter_customer-receives/trashed',[SlaughterCustomerReceiveController::class,'trashed_list'])->middleware('permission:slaughter_customer_receive_manage')->name('slaughter_customer-receives.trashed');
Route::get('/slaughter_customer-receives/trashed/{slaughter_customer_receive}/restore',[SlaughterCustomerReceiveController::class,'restore'])->middleware('permission:slaughter_customer_receive_manage')->name('slaughter_customer-receives.restore');
Route::get('/slaughter_customer-receives/trashed/{slaughter_customer_receive}/delete',[SlaughterCustomerReceiveController::class,'force_delete'])->middleware('permission:slaughter_customer_receive_manage')->name('slaughter_customer-receives.force_delete');
Route::get('/slaughter_customer-receives/{slaughter_customer_receive}/approve',[SlaughterCustomerReceiveController::class,'approve'])->middleware('permission:slaughter_customer_receive_approve')->name('slaughter_customer-receives.approve');
Route::resource('/slaughter_customer-receives',SlaughterCustomerReceiveController::class)->middleware('permission:slaughter_customer_receive_manage');

//Slaughter Sale
Route::get('/slaughter_sales/trashed',[SlaughterSaleController::class,'trashed_list'])->middleware('permission:slaughter_sale_manage')->name('slaughter_sales.trashed');
Route::get('/slaughter_sales/trashed/{slaughter_sale}/restore',[SlaughterSaleController::class,'restore'])->middleware('permission:slaughter_sale_manage')->name('slaughter_sales.restore');
Route::get('/slaughter_sales/trashed/{slaughter_sale}/delete',[SlaughterSaleController::class,'force_delete'])->middleware('permission:slaughter_sale_manage')->name('slaughter_sales.force_delete');
Route::post('/slaughter_sales/{slaughter_sale}/approve',[SlaughterSaleController::class,'approve'])->middleware('permission:slaughter_sale_approve')->name('slaughter_sales.approve');
Route::resource('/slaughter_sales',SlaughterSaleController::class)->middleware('permission:slaughter_sale_manage');

//Slaughter Waste
Route::get('/slaughter_wastes/trashed',[SlaughterWasteController::class,'trashed_list'])->middleware('permission:slaughter_waste_manage')->name('slaughter_wastes.trashed');
Route::get('/slaughter_wastes/trashed/{slaughter_waste}/restore',[SlaughterWasteController::class,'restore'])->middleware('permission:slaughter_waste_manage')->name('slaughter_wastes.restore');
Route::get('/slaughter_wastes/trashed/{slaughter_waste}/delete',[SlaughterWasteController::class,'force_delete'])->middleware('permission:slaughter_waste_manage')->name('slaughter_wastes.force_delete');
Route::post('/slaughter_wastes/{slaughter_waste}/approve',[SlaughterWasteController::class,'approve'])->middleware('permission:slaughter_waste_approve')->name('slaughter_wastes.approve');
Route::resource('/slaughter_wastes',SlaughterWasteController::class)->middleware('permission:slaughter_waste_manage');


//Staff Payment
Route::get('/staff-payments/trashed',[StaffPaymentController::class,'trashed_list'])->middleware('permission:staff_payment_manage')->name('staff-payments.trashed');
Route::get('/staff-payments/trashed/{staff_payment}/restore',[StaffPaymentController::class,'restore'])->middleware('permission:staff_payment_manage')->name('staff-payments.restore');
Route::get('/staff-payments/trashed/{staff_payment}/delete',[StaffPaymentController::class,'force_delete'])->middleware('permission:staff_payment_manage')->name('staff-payments.force_delete');
Route::get('/staff-payments/{staff_payment}/approve',[StaffPaymentController::class,'approve'])->middleware('permission:staff_payment_approve')->name('staff-payments.approve');
Route::resource('/staff-payments',StaffPaymentController::class)->middleware('permission:staff_payment_manage');

//Setting
Route::get('global-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'global_setting'])->name('global_setting');
Route::post('update-global-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'update_global_setting'])->name('update_global_setting');
