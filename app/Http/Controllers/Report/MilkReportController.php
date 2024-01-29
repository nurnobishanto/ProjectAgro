<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\MilkProduction;
use App\Models\MilkSale;
use App\Models\MilkWaste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MilkReportController extends Controller
{
    public function index(Request $request){
        App::setLocale(session('locale'));
        $milk_productions = MilkProduction::all();
        $milk_sales = MilkSale::all();
        $milk_wastes = MilkWaste::all();

        if ($request->farm_id){
            $milk_sales = $milk_sales->where('farm_id',$request->farm_id);
            $milk_wastes = $milk_wastes->where('farm_id',$request->farm_id);
            $milk_productions = $milk_productions->where('farm_id',$request->farm_id);
        }
        if ($request->milk_sale_party_id){
            $milk_sales = $milk_sales->where('milk_sale_party_id',$request->milk_sale_party_id);
        }
        if ($request->status){
            $milk_sales = $milk_sales->where('status',$request->status);
            $milk_wastes = $milk_wastes->where('status',$request->status);
            $milk_productions = $milk_productions->where('status',$request->status);
        }
        if ($request->from_date){
            $milk_sales = $milk_sales->where('date','>=',$request->from_date);
            $milk_wastes = $milk_wastes->where('date','>=',$request->from_date);
            $milk_productions = $milk_productions->where('date','>=',$request->from_date);
        }
        if ($request->to_date){
            $milk_sales = $milk_sales->where('date','<=',$request->to_date);
            $milk_wastes = $milk_wastes->where('date','<=',$request->to_date);
            $milk_productions = $milk_productions->where('date','<=',$request->to_date);
        }
        if ($request->cattle_type_id){ $milk_productions = $milk_productions->where('cattle_type_id',$request->cattle_type_id); }
        if ($request->tag_id){ $milk_productions = $milk_productions->where('tag_id',$request->tag_id); }
        if ($request->moment){ $milk_productions = $milk_productions->where('moment',$request->moment); }

        $data = array();
        $data['milk_sales'] = $milk_sales;
        $data['milk_wastes'] = $milk_wastes;
        $data['milk_productions'] = $milk_productions;

        $data['farm_id'] = $request->farm_id??null;
        $data['cattle_type_id'] = $request->cattle_type_id??null;
        $data['tag_id'] = $request->tag_id??null;
        $data['milk_sale_party_id'] = $request->milk_sale_party_id??null;
        $data['from_date'] = $request->from_date??null;
        $data['to_date'] = $request->to_date??null;
        $data['moment'] = $request->moment??null;
        $data['status'] = $request->status??null;
        return view('report.milk.index',$data);
    }
    public function production(Request $request){
        App::setLocale(session('locale'));
        $milk_productions = MilkProduction::all();
        if ($request->farm_id){ $milk_productions = $milk_productions->where('farm_id',$request->farm_id); }
        if ($request->cattle_type_id){ $milk_productions = $milk_productions->where('cattle_type_id',$request->cattle_type_id); }
        if ($request->tag_id){ $milk_productions = $milk_productions->where('tag_id',$request->tag_id); }
        if ($request->status){ $milk_productions = $milk_productions->where('status',$request->status); }
        if ($request->moment){ $milk_productions = $milk_productions->where('moment',$request->moment); }
        if ($request->from_date){ $milk_productions = $milk_productions->where('date','>=',$request->from_date); }
        if ($request->to_date){ $milk_productions = $milk_productions->where('date','<=',$request->to_date); }
        $data = array();
        $data['milk_productions'] = $milk_productions;
        $data['farm_id'] = $request->farm_id??null;
        $data['cattle_type_id'] = $request->cattle_type_id??null;
        $data['tag_id'] = $request->tag_id??null;
        $data['from_date'] = $request->from_date??null;
        $data['to_date'] = $request->to_date??null;
        $data['moment'] = $request->moment??null;
        $data['status'] = $request->status??null;
        return view('report.milk.production',$data);
    }
    public function sale(Request $request){
        App::setLocale(session('locale'));
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
        App::setLocale(session('locale'));
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
