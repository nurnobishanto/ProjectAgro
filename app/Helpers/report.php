<?php


use App\Models\Account;
use App\Models\FeedingRecord;
use App\Models\GlobalSetting;
use App\Models\Party;
use App\Models\Treatment;

if (!function_exists('getCattleTotalCost')) {

    function getCattleTotalCost($cattle)
    {
        $purchase_price = $cattle->purchase_price;
        $feeding_cost = $cattle->feedingRecords->where('status','success')->sum('per_cattle_cost');
        $dewormer_cost = $cattle->dewormers->where('status','success')->sum('avg_cost');
        $vaccine_cost = $cattle->vaccines->where('status','success')->sum('avg_cost');
        $treatment_cost = $cattle->treatments->where('status','success')->sum('cost');
        $data = array();
        $data['purchase_price'] = $purchase_price;
        $data['feeding_cost'] = $feeding_cost;
        $data['dewormer_cost'] = $dewormer_cost;
        $data['vaccine_cost'] = $vaccine_cost;
        $data['treatment_cost'] = $treatment_cost;
        $data['total'] = $purchase_price + $feeding_cost + $dewormer_cost + $vaccine_cost + $treatment_cost;
        return $data;
    }
}

if (!function_exists('getTotalAvgExpenseCost')) {

    function getTotalAvgExpenseCost($customDate = null)
    {
        $date = $customDate ? Carbon\Carbon::parse($customDate)->endOfDay() : now();
        $assigned_cost = \App\Models\AssignedCost::where('date', '<=', $date)->sum('amount');
        $total_expense = \App\Models\Expense::where('status','success')->where('date', '<=', $date)->sum('amount');
        $staff_payments = \App\Models\StaffPayment::where('status','success')->where('date', '<=', $date)->sum('amount');
        $active_cattle = \App\Models\Cattle::where('status','active')->count();
        $death_cattle_cost = \App\Models\CattleDeath::where('status','approved')->where('date', '<=', $date)->sum('amount');
        $total_cost = ($total_expense + $staff_payments + $death_cattle_cost) - $assigned_cost;


        $data = array();
        $data['date'] = $date;
        $data['death_cattle_cost'] = $death_cattle_cost;
        $data['assigned_cost'] = $assigned_cost;
        $data['total_expense'] = $total_expense;
        $data['staff_payments'] = $staff_payments;
        $data['active_cattle'] = $active_cattle;
        $data['total_cost'] = $total_cost;
        $data['avg_cost'] =($active_cattle)?($total_cost / $active_cattle):0;
        return $data;
    }
}
