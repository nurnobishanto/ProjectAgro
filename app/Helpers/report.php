<?php


use App\Models\Account;
use App\Models\FeedingRecord;
use App\Models\GlobalSetting;
use App\Models\Party;
use App\Models\Treatment;
use Carbon\Carbon;


if (!function_exists('getCattleTotalCost')) {

    function getCattleTotalCost($cattle,$customDate = null)
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
        $total = $purchase_price + $feeding_cost + $dewormer_cost + $vaccine_cost + $treatment_cost;
        $data['total'] = $purchase_price + $feeding_cost + $dewormer_cost + $vaccine_cost + $treatment_cost;
        $data['avg_other_cost'] = getTotalAvgExpenseCost($customDate)['avg_cost'];
        $data['grand_total'] = $total + getTotalAvgExpenseCost($customDate)['avg_cost'];
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


function filterDataByTimeInterval($data, $type, $limit)
{
    switch ($type) {
        case 'daily':
            return $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })->map(function ($group) {
                return [
                    'date' => Carbon::parse($group->first()->date)->format('Y-m-d'), // Use the date of the first item in the group
                    'm_quantity' => $group->where('moment','morning')->sum('quantity'),
                    'e_quantity' => $group->where('moment','evening')->sum('quantity'),
                ];
            })->take($limit);
        case 'monthly':
            return $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m');
            })->map(function ($group) {
                return [
                    'date' => Carbon::parse($group->first()->date)->format('Y-m'), // Use the date of the first item in the group
                    'm_quantity' => $group->where('moment','morning')->sum('quantity'),
                    'e_quantity' => $group->where('moment','evening')->sum('quantity'),
                ];
            })->take($limit);
        case 'yearly':
            return $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y');
            })->map(function ($group) {
                return [
                    'date' => Carbon::parse($group->first()->date)->format('Y'), // Use the date of the first item in the group
                    'm_quantity' => $group->where('moment','morning')->sum('quantity'),
                    'e_quantity' => $group->where('moment','evening')->sum('quantity'),
                ];
            })->take($limit);
        default:
            return $data->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })->map(function ($group) {
                return [
                    'date' => Carbon::parse($group->first()->date)->format('Y-m-d') , // Use the date of the first item in the group
                    'm_quantity' => $group->where('moment','morning')->sum('quantity'),
                    'e_quantity' => $group->where('moment','evening')->sum('quantity'),
                ];
            })->take($limit);
    }
}
if (!function_exists('getLineChartForMilkProduction')) {

    function getLineChartForMilkProduction($cattleId = null, $startDate = null, $endDate = null,$type = "daily", $limit = 7)
    {

        $data =  \App\Models\MilkProduction::where('status','success');
        if ($cattleId) {
            $data->where('cattle_id', $cattleId);
        }

        if ($startDate) {
            $data->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $data->where('date', '<=', $endDate);
        }
        $data = $data->get();

        // Filter data based on the time interval and limit
        $filteredData = filterDataByTimeInterval($data, $type, $limit);

        $labels = [];
        $morningQuantities = [];
        $eveningQuantities = [];

        foreach ($filteredData as $item) {

            $labels[] = $item['date'];
            $morningQuantities[] = $item['m_quantity'];
            $eveningQuantities[] = $item['e_quantity'];
        }


        $morningSum = array_sum($morningQuantities);
        $eveningSum = array_sum($eveningQuantities);
        return [
            'data' => [
                'labels' => $labels,
                'datasets' => [

                    [
                        'label' => 'Morning (Total: ' . $morningSum .' '.__('global.ltr'). ')',
                        'backgroundColor' => 'rgba(70,141,188,0.9)',
                        'borderColor' => 'rgba(60,141,188,0.8)',
                        'pointRadius' => false,
                        'pointColor' => '#3b8bba',
                        'pointStrokeColor' => 'rgba(60,141,188,1)',
                        'pointHighlightFill' => '#fff',
                        'pointHighlightStroke' => 'rgba(60,141,188,1)',
                        'data' => $morningQuantities,
                    ],
                    [
                        'label' => 'Evening (Total: ' . $eveningSum .' '.__('global.ltr'). ')',
                        'backgroundColor' => 'rgba(55, 1, 255, 1)',
                        'borderColor' => 'rgba(210, 214, 222, 1)',
                        'pointRadius' => false,
                        'pointColor' => 'rgba(210, 214, 222, 1)',
                        'pointStrokeColor' => '#c1c7d1',
                        'pointHighlightFill' => '#fff',
                        'pointHighlightStroke' => 'rgba(220,220,220,1)',
                        'data' => $eveningQuantities,
                    ],
                ],
            ],
            'options' => [
                'maintainAspectRatio' => true,
                'responsive' => true,
                'legend' => [
                    'display' => true,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'gridLines' => [
                                'display' => true,
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'gridLines' => [
                                'display' => true,
                            ],
                            'ticks' => [
                                'beginAtZero' => true, // Ensure the y-axis starts from 0.0
                            ],
                        ],

                    ],
                ],
            ],
        ];
    }
}
