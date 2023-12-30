<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\MilkStock;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MilkStockController extends Controller
{
    public function milk_stock(Request $request){
        App::setLocale(session('locale'));
        $milk_stocks = MilkStock::all();
        $farm_id = $request->farm_id??0;


        if ($request->farm_id){
            $milk_stocks = $milk_stocks->where('farm_id',$request->farm_id);
        }

        $total = 0;
        foreach ($milk_stocks as $stock){
            $total += $stock->quantity;
        }
        return view('admin.milk_productions.stock',compact('milk_stocks','farm_id','total'));
    }
}
