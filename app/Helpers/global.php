<?php


use App\Models\Account;
use App\Models\FeedingRecord;
use App\Models\GlobalSetting;
use App\Models\Party;
use App\Models\Treatment;


if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {

    }
}
if (!function_exists('getSlaughterCustomer')) {

    function getSlaughterCustomer()
    {
        return \App\Models\SlaughterCustomer::all();
    }
}
if (!function_exists('getSlaughterItems')) {

    function getSlaughterItems()
    {
        return \App\Models\Product::where('type','slaughter_item')->get();
    }
}
if (!function_exists('getSlaughterStore')) {

    function getSlaughterStore()
    {
        return \App\Models\SlaughterStore::where('status','active')->get();
    }
}
if (!function_exists('getPartyList')) {

    function getPartyList()
    {
        return Party::all();
    }
}
if (!function_exists('getAccountList')) {

    function getAccountList()
    {
        $user = auth()->user();
        $accounts = Account::where('status','active')->get();
        if (!$user->can('account_manage')){
            $accounts->where('admin_id',$user->id);
        }
        return $accounts;
    }
}
if (!function_exists('getPayType')) {

    function getPayType()
    {
        $type = [
           // 'hourly' => __('global.hourly'),
            'daily' => __('global.daily'),
          //  'weekly' => __('global.weekly'),
            'monthly' => __('global.monthly'),
            'yearly' => __('global.yearly'),
        ];
        return $type;
    }
}
if (!function_exists('getAccountType')) {

    function getAccountType()
    {
        $type = [
            'cash' => __('global.cash'),
            'bank' => __('global.bank'),
            'mobile_bank' => __('global.mobile_bank'),
        ];
        return $type;
    }
}
if (!function_exists('getFeedRecordProduct')) {
    function getFeedRecordProduct($record_id, $product_id)
    {
        $feedingRecord = FeedingRecord::find($record_id);

        if (!$feedingRecord) {
            return [];
        }

        $product = $feedingRecord->products()->wherePivot('product_id', $product_id)->first();

        return $product ? $product->pivot : [];
    }
}
if (!function_exists('getTreatmentProduct')) {
    function getTreatmentProduct($treatment_id, $product_id)
    {
        $treatment = Treatment::find($treatment_id);

        if (!$treatment) {
            return [];
        }

        $product = $treatment->products()->wherePivot('product_id', $product_id)->first();

        return $product ? $product->pivot : [];
    }
}
if (!function_exists('getStock')) {

    function getStock($farm_id,$product_id)
    {
        return \App\Models\Stock::where('farm_id',$farm_id)->where('product_id',$product_id)->first();
    }
}
if (!function_exists('getLatestCattleStructure')) {

    function getLatestCattleStructure($id,$column)
    {
        $cattleStructure = \App\Models\CattleStructure::where('cattle_id',$id)->orderBy('id','desc')->first();
        return $cattleStructure->$column;
    }
}
if (!function_exists('getPurchaseProducts')) {

    function getPurchaseProducts($id)
    {
        return \App\Models\PurchaseProduct::where('purchase_id',$id)->get();
    }
}
if (!function_exists('generateInvoiceId')) {

    function generateInvoiceId($prefix,$model = \App\Models\Product::class,$slug = 'code')
    {
        do{
            $value = $prefix.'-'.rand(11111,99999);
        }while(!$model::where($slug,$value));
        return $value;
    }
}

if (!function_exists('getParties')) {

    function getParties()
    {
        return \App\Models\Party::all();
    }
}
if (!function_exists('getSuppliers')) {

    function getSuppliers()
    {
        return \App\Models\Supplier::all();
    }
}
if (!function_exists('getFarms')) {

    function getFarms()
    {
        return \App\Models\Farm::all();
    }
}
if (!function_exists('getCattleTypes')) {

    function getCattleTypes()
    {
        return \App\Models\CattleType::all();
    }
}
if (!function_exists('getTax')) {

    function getTax()
    {
        return \App\Models\Tax::all();
    }
}
if (!function_exists('getFeedItems')) {

    function getFeedItems()
    {
        return \App\Models\Product::where('type','cattle_meal')->get();
    }
}
if (!function_exists('getProductsForPurchase')) {

    function getProductsForPurchase()
    {
        return \App\Models\Product::whereNotIn('type', ['milk_collection', 'slaughter_item'])->get();
    }
}
if (!function_exists('getAdmins')) {

    function getAdmins()
    {
        return \App\Models\Admin::all();
    }
}

if (!function_exists('getAllData')) {

    function getAllData($model)
    {
        return $model::all();
    }
}
if (!function_exists('getDataById')) {

    function getDataById($model,$id)
    {
        return $model::find($id);
    }
}
if (!function_exists('calculateAgeInDaysFromDate')) {

    function calculateAgeInDaysFromDate($inputDate) {
        $inputDateTime = new DateTime($inputDate);
        $currentDateTime = new DateTime();
        $interval = $currentDateTime->diff($inputDateTime);
        $ageInDays = $interval->days;
        return $ageInDays.' Days';
    }
}
if (!function_exists('productCodeGenerate')) {

    function productCodeGenerate()
    {
        do{
            $value = 'PID-'.rand(11111,99999);
        }while(!\App\Models\Product::where('code',$value));
        return $value;
    }
}
if (!function_exists('setSetting')) {

    function setSetting($key, $value)
    {
         GlobalSetting::updateOrInsert(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $setting = GlobalSetting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return null;
    }
}
if (!function_exists('checkRolePermissions')) {

    function checkRolePermissions($role,$permissions){
        $status = true;
        foreach ($permissions as $permission){
            if(!$role->hasPermissionTo($permission)){
                $status = false;
            }
        }

        return $status;
    }
}
if (!function_exists('checkAdminRole')) {

    function checkAdminRole($admin,$role){
        $status = false;
       if($admin->hasAnyRole([$role])){
           $status = true;
       }

        return $status;
    }
}



