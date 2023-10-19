<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\CattleType;
use App\Models\Dewormer;
use App\Models\Farm;
use App\Models\FeedingRecord;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class DewormerController extends Controller
{
    public function trashed_list(){
        App::setLocale(session('locale'));
        $dewormers = Dewormer::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.dewormers.trashed',compact('dewormers'));
    }
    public function index(Request $request)
    {
        App::setLocale(session('locale'));

        $dewormers = Dewormer::orderBy('id','DESC')->get();
        if ($request->date){
            $dewormers = $dewormers->where('date',$request->date);
        }
        if ($request->status){
            $dewormers = $dewormers->where('status',$request->status);
        }
        if ($request->updated_by){
            $dewormers = $dewormers->where('updated_by',$request->updated_by);
        }
        if ($request->created_by){
            $dewormers = $dewormers->where('created_by',$request->created_by);
        }
        if ($request->farm_id){
            $dewormers = $dewormers->where('farm_id',$request->farm_id);
        }
        if ($request->product_id){
            $dewormers = $dewormers->where('product_id',$request->product_id);
        }
        if ($request->cattle_id){
            $dewormers = $dewormers->where('cattle_id',$request->cattle_id);
        }
        $products =  Product::where('type','cattle_medicine')->where('status','active')->get();
        return view('admin.dewormers.index',compact(['dewormers','products']));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.dewormers.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $data = array();
        $data['farm'] = Farm::where('id',$request->farm_id)->first();;
        $data['cattle_type'] = CattleType::where('id',$request->cattle_type_id)->first();;
        $data['cattles'] = Cattle::where('farm_id',$request->farm_id)->where('cattle_type_id',$request->cattle_type_id)->get();;
        $data['product'] = Product::where('id',$request->product_id)->where('status','active')->first();
        return view('admin.dewormers.create',$data);
    }
    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
            'date' => 'required',
            'end_date' => 'required',
            'time' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'cattles' => 'required',
        ]);

        $dewormer = Dewormer::where('date',$request->date)
            ->where('farm_id',$request->farm_id)
            ->first();
        $product = Product::find($request->product_id);
        $quantity = $request->quantity;

        if (!$dewormer && $product){
            $stock  =  getStock($request->farm_id,$product->id);
            $stkQTY = 0;
            $stkPrice = 0;
            if ($stock){
                $stkQTY = $stock->quantity;
                $stkPrice = $stock->unit_price;
            }
            $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
            $feedCost = Round(($feedQTY * $stkPrice),2);

            $avg_cost = Round($feedCost/count($request->cattles),2);

            $dewormer = Dewormer::create([
                'date' => $request->date,
                'end_date' => $request->end_date,
                'time' => $request->time,
                'farm_id' => $request->farm_id,
                'cattle_type_id' => $request->cattle_type_id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $stkPrice,
                'comment' => $request->comment,
                'total_cost' => $feedCost,
                'avg_cost' => $avg_cost,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            $dewormer->cattles()->sync($request->cattles);
            if ($stock){
                $stock->quantity = $stkQTY-$feedQTY;
                $stock->update();
            }
            toastr()->success(__('global.created_success'),__('global.dewormer').__('global.created'));

        }else{
            toastr()->warning(__('global.already_created'),__('global.dewormer').__('global.already_created'));
        }
        return redirect()->route('admin.dewormers.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $dewormer = Dewormer::find($id);
        $data = array();
        $data['dewormer'] = $dewormer;
        $data['cattles'] = Cattle::where('farm_id',$dewormer->farm_id)->where('cattle_type_id',$dewormer->cattle_type_id)->get();

        return view('admin.dewormers.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $dewormer = Dewormer::find($id);
        $data = array();
        $data['dewormer'] = $dewormer;
        $data['farm'] = $dewormer->farm;
        $data['product'] = $dewormer->product;
        $data['cattle_type'] = $dewormer->cattle_type;
        $data['cattles'] = Cattle::where('farm_id',$dewormer->farm_id)->where('cattle_type_id',$dewormer->cattle_type_id)->get();
        return view('admin.dewormers.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
            'date' => 'required',
            'end_date' => 'required',
            'time' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'cattles' => 'required',
        ]);

        $dewormer = Dewormer::find($id);

        $dewormer->time = $request->time;
        $dewormer->end_date = $request->end_date;
        $dewormer->comment = $request->comment;
        $dewormer->updated_by = auth()->user()->id;
        $dewormer->update();


        $quantity = $request->quantity ?? 0;

        $stock  =  getStock($dewormer->farm_id,$dewormer->product_id);
        $stkQTY = 0;
        $stkPrice = 0;
        if ($stock){
            $stkQTY = $stock->quantity + $dewormer->quantity??0;
            $stkPrice = $stock->unit_price;
        }
        $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
        $feedCost = Round(($feedQTY * $stkPrice),2);

        if ($stock){
            $stock->quantity = $stkQTY - $feedQTY;
            $stock->update();
        }

        $dewormer->cattles()->detach();
        $dewormer->cattles()->sync($request->cattles);
        $dewormer->quantity = $feedQTY;
        $dewormer->unit_price = $stkPrice;
        $dewormer->total_cost = $feedCost;

        $dewormer->avg_cost = Round(($feedCost /  $dewormer->cattles->count()),2);
        $dewormer->update();

        toastr()->success(__('global.updated_success'),__('global.dewormer').__('global.updated'));
        return redirect()->route('admin.dewormers.index');
    }
    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $dewormer = Dewormer::find($id);
        $product = $dewormer->product;
        $stock = Stock::where('farm_id',$dewormer->farm_id)->where('product_id',$product->id)->first();
        if ($stock){
            $preQty = $stock->quantity;
            $preUnitPrice = $stock->unit_price;
            $preBalance = $preQty * $preUnitPrice;

            $newQty = $dewormer->quantity;
            $newUnitPrice =  $dewormer->unit_price;
            $newBalance = $newQty * $newUnitPrice;

            $updateBalance = $preBalance + $newBalance;
            $updateQty = $newQty + $preQty;

            $updateUnitPrice = $updateQty?round(($updateBalance/$updateQty),2):0;

            $stock->quantity = $updateQty;
            $stock->unit_price = $updateUnitPrice;
            $stock->update();

        }else{
            Stock::create([
                'farm_id' => $dewormer->farm_id,
                'product_id' => $dewormer->product_id,
                'quantity' => $dewormer->quantity,
                'unit_price' => $dewormer->unit_price,
            ]);
        }

        $dewormer->delete();
        toastr()->warning($dewormer->name.__('global.deleted_success'),__('global.dewormer').__('global.deleted'));
        return redirect()->route('admin.dewormers.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $dewormer = Dewormer::withTrashed()->find($id);
        $quantity = $dewormer->quantity ?? 0;
        $unit_price = $dewormer->unit_price ?? 0;
        $stock =  getStock($dewormer->farm_id,$dewormer->product_id);
        $stkQTY = 0;
        $stockTotal = 0;
        if ($stock){
            $stkQTY = $stock->quantity ;
            $stkUnitPrice = $stock->unit_price;
            $stockTotal = $stkQTY * $stkUnitPrice;
        }
        $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
        $feedCost = Round(($feedQTY * $unit_price),2);

        $updateStockQty  = $stkQTY - $feedQTY;
        $updateStockTotal  = $stockTotal - $feedCost;
        $updateStockUnitPrice  = $updateStockQty?round(($updateStockTotal / $updateStockQty),2):0;

        $dewormer->unit_price = $unit_price;
        $dewormer->quantity = $feedQTY;
        $dewormer->total_cost = $feedCost;

        if ($stock){
            $stock->quantity = $updateStockQty;
            $stock->unit_price = $updateStockUnitPrice;
            $stock->update();
        }

        $dewormer->deleted_at = null;
        $dewormer->update();
        toastr()->success($dewormer->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.dewormers.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $dewormer = Dewormer::withTrashed()->find($id);
        $dewormer->cattles()->detach();
        $dewormer->forceDelete();
        toastr()->error(__('global.dewormer').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.dewormers.trashed');
    }
    public function approve ($id){
        $dewormer = Dewormer::find($id);
        $dewormer->status = 'success';
        $dewormer->update();
        toastr()->success($dewormer->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.dewormers.index');
    }
}
