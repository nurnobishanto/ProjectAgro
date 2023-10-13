<?php


use App\Models\GlobalSetting;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {

    }
}
if (!function_exists('getPurchaseProducts')) {

    function getPurchaseProducts($id)
    {
        return \App\Models\PurchaseProduct::where('purchase_id',$id)->get();
    }
}
if (!function_exists('generateInvoiceId')) {

    function generateInvoiceId($prefix,$model = \App\Models\Product::class)
    {
        do{
            $value = $prefix.'-'.rand(11111,99999);
        }while(!$model::where('code',$value));
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
if (!function_exists('getTax')) {

    function getTax()
    {
        return \App\Models\Tax::all();
    }
}
if (!function_exists('getProducts')) {

    function getProducts()
    {
        return \App\Models\Product::all();
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



