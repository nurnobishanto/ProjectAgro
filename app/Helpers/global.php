<?php


use App\Models\GlobalSetting;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {
        // Your custom logic here
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



