<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\BulkCattleSale;
use App\Models\Cattle;
use App\Models\CattleSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CattleReportController extends Controller
{
    public function expense_report(Request $request){
        App::setLocale(session('locale'));
        $cattles = Cattle::where('status','active')->orderBy('updated_at','desc');
        //return $cattles;
        if ($request->farm_id){ $cattles = $cattles->where('farm_id',$request->farm_id); }
        if ($request->cattle_type_id){ $cattles = $cattles->where('cattle_type_id',$request->cattle_type_id); }
        if ($request->tag_id){ $cattles = $cattles->where('id',$request->tag_id); }

        $data = array();
        $data['cattles'] = $cattles->get();
        return view('report.cattle.expense_report',$data);
    }
    public function sale_report(Request $request){
        App::setLocale(session('locale'));
        $cattle_sales = CattleSale::where('status','success')->orderBy('updated_at','desc');

        $data = array();
        $data['cattle_sales'] = $cattle_sales->get();
        return view('report.cattle.sale_report',$data);
    }
    public function bulk_sale_report(Request $request){
        App::setLocale(session('locale'));
        $bulk_cattle_sales = BulkCattleSale::where('status','success')->orderBy('updated_at','desc');
//        //return $cattles;
//        if ($request->farm_id){ $cattles = $cattles->where('farm_id',$request->farm_id); }
//        if ($request->cattle_type_id){ $cattles = $cattles->where('cattle_type_id',$request->cattle_type_id); }
//        if ($request->tag_id){ $cattles = $cattles->where('id',$request->tag_id); }

        $data = array();
        $data['bulk_cattle_sales'] = $bulk_cattle_sales->get();
        return view('report.cattle.bulk_sale_report',$data);
    }
}
