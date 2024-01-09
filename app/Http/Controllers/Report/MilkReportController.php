<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MilkSale;
use App\Models\MilkWaste;
use Illuminate\Http\Request;

class MilkReportController extends Controller
{
    public function index(Request $request){
        $data = array();
        $data['milk_sales'] = MilkSale::all();
        return view('report.milk.index',$data);
    }
    public function production(Request $request){
        $data = array();
        $data['milk_sales'] = MilkSale::all();
        return view('report.milk.production',$data);
    }
    public function sale(Request $request){
        $milk_sales = MilkSale::all();
        if ($request->farm_id){ $milk_sales = $milk_sales->where('farm_id',$request->farm_id); }
        if ($request->milk_sale_party_id){ $milk_sales = $milk_sales->where('milk_sale_party_id',$request->milk_sale_party_id); }
        if ($request->status){ $milk_sales = $milk_sales->where('status',$request->status); }
        if ($request->from_date){ $milk_sales = $milk_sales->where('date','>=',$request->from_date); }
        if ($request->to_date){ $milk_sales = $milk_sales->where('date','<=',$request->to_date); }
        $data = array();
        $data['milk_sales'] = $milk_sales;
        $data['farm_id'] = $request->farm_id??null;
        $data['milk_sale_party_id'] = $request->milk_sale_party_id??null;
        $data['from_date'] = $request->from_date??null;
        $data['to_date'] = $request->to_date??null;
        $data['status'] = $request->status??null;
        return view('report.milk.sale',$data);
    }
    public function waste(Request $request){
        $milk_wastes = MilkWaste::all();
        if ($request->farm_id){ $milk_wastes = $milk_wastes->where('farm_id',$request->farm_id); }
        if ($request->status){ $milk_wastes = $milk_wastes->where('status',$request->status); }
        if ($request->from_date){ $milk_wastes = $milk_wastes->where('date','>=',$request->from_date); }
        if ($request->to_date){ $milk_wastes = $milk_wastes->where('date','<=',$request->to_date); }
        $data = array();
        $data['milk_wastes'] = $milk_wastes;
        $data['farm_id'] = $request->farm_id??null;
        $data['from_date'] = $request->from_date??null;
        $data['to_date'] = $request->to_date??null;
        $data['status'] = $request->status??null;
        return view('report.milk.waste',$data);
    }
}
