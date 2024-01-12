<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use Illuminate\Http\Request;

class CattleReportController extends Controller
{
    public function index(Request $request){
        $cattles = Cattle::all();
        //return $cattles;
        if ($request->farm_id){ $cattles = $cattles->where('farm_id',$request->farm_id); }
        if ($request->cattle_type_id){ $cattles = $cattles->where('cattle_type_id',$request->cattle_type_id); }
        if ($request->tag_id){ $cattles = $cattles->where('tag_id',$request->tag_id); }

        $data = array();
        $data['cattles'] = $cattles;
        return view('report.cattle.index',$data);
    }
}
