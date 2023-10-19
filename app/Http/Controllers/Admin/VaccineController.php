<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\CattleType;
use App\Models\Vaccine;
use App\Models\Farm;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
class VaccineController extends Controller
{
    public function trashed_list(){
        App::setLocale(session('locale'));
        $vaccines = Vaccine::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.vaccines.trashed',compact('vaccines'));
    }
    public function index(Request $request)
    {
        App::setLocale(session('locale'));

        $vaccines = Vaccine::orderBy('id','DESC')->get();
        if ($request->date){
            $vaccines = $vaccines->where('date',$request->date);
        }
        if ($request->status){
            $vaccines = $vaccines->where('status',$request->status);
        }
        if ($request->updated_by){
            $vaccines = $vaccines->where('updated_by',$request->updated_by);
        }
        if ($request->created_by){
            $vaccines = $vaccines->where('created_by',$request->created_by);
        }
        if ($request->farm_id){
            $vaccines = $vaccines->where('farm_id',$request->farm_id);
        }
        if ($request->product_id){
            $vaccines = $vaccines->where('product_id',$request->product_id);
        }
        if ($request->cattle_id){
            $vaccines = $vaccines->where('cattle_id',$request->cattle_id);
        }
        $products =  Product::where('type','cattle_medicine')->where('status','active')->get();
        return view('admin.vaccines.index',compact(['vaccines','products']));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.vaccines.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $data = array();
        $data['farm'] = Farm::where('id',$request->farm_id)->first();;
        $data['cattle_type'] = CattleType::where('id',$request->cattle_type_id)->first();;
        $data['cattles'] = Cattle::where('farm_id',$request->farm_id)->where('cattle_type_id',$request->cattle_type_id)->get();;
        $data['product'] = Product::where('id',$request->product_id)->where('status','active')->first();
        return view('admin.vaccines.create',$data);
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

        $vaccine = Vaccine::where('date',$request->date)
            ->where('farm_id',$request->farm_id)
            ->first();
        $product = Product::find($request->product_id);
        $quantity = $request->quantity;

        if (!$vaccine && $product){
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

            $vaccine = Vaccine::create([
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
            $vaccine->cattles()->sync($request->cattles);
            if ($stock){
                $stock->quantity = $stkQTY-$feedQTY;
                $stock->update();
            }
            toastr()->success(__('global.created_success'),__('global.vaccine').__('global.created'));

        }else{
            toastr()->warning(__('global.already_created'),__('global.vaccine').__('global.already_created'));
        }
        return redirect()->route('admin.vaccines.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $vaccine = Vaccine::find($id);
        $data = array();
        $data['vaccine'] = $vaccine;
        $data['cattles'] = Cattle::where('farm_id',$vaccine->farm_id)->where('cattle_type_id',$vaccine->cattle_type_id)->get();

        return view('admin.vaccines.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $vaccine = Vaccine::find($id);
        $data = array();
        $data['vaccine'] = $vaccine;
        $data['farm'] = $vaccine->farm;
        $data['product'] = $vaccine->product;
        $data['cattle_type'] = $vaccine->cattle_type;
        $data['cattles'] = Cattle::where('farm_id',$vaccine->farm_id)->where('cattle_type_id',$vaccine->cattle_type_id)->get();
        return view('admin.vaccines.edit',$data);
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

        $vaccine = Vaccine::find($id);

        $vaccine->time = $request->time;
        $vaccine->end_date = $request->end_date;
        $vaccine->comment = $request->comment;
        $vaccine->updated_by = auth()->user()->id;
        $vaccine->update();


        $quantity = $request->quantity ?? 0;

        $stock  =  getStock($vaccine->farm_id,$vaccine->product_id);
        $stkQTY = 0;
        $stkPrice = 0;
        if ($stock){
            $stkQTY = $stock->quantity + $vaccine->quantity??0;
            $stkPrice = $stock->unit_price;
        }
        $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
        $feedCost = Round(($feedQTY * $stkPrice),2);

        if ($stock){
            $stock->quantity = $stkQTY - $feedQTY;
            $stock->update();
        }

        $vaccine->cattles()->detach();
        $vaccine->cattles()->sync($request->cattles);
        $vaccine->quantity = $feedQTY;
        $vaccine->unit_price = $stkPrice;
        $vaccine->total_cost = $feedCost;

        $vaccine->avg_cost = Round(($feedCost /  $vaccine->cattles->count()),2);
        $vaccine->update();

        toastr()->success(__('global.updated_success'),__('global.vaccine').__('global.updated'));
        return redirect()->route('admin.vaccines.index');
    }
    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $vaccine = Vaccine::find($id);
        $product = $vaccine->product;
        $stock = Stock::where('farm_id',$vaccine->farm_id)->where('product_id',$product->id)->first();
        if ($stock){
            $preQty = $stock->quantity;
            $preUnitPrice = $stock->unit_price;
            $preBalance = $preQty * $preUnitPrice;

            $newQty = $vaccine->quantity;
            $newUnitPrice =  $vaccine->unit_price;
            $newBalance = $newQty * $newUnitPrice;

            $updateBalance = $preBalance + $newBalance;
            $updateQty = $newQty + $preQty;

            $updateUnitPrice = $updateQty?round(($updateBalance/$updateQty),2):0;

            $stock->quantity = $updateQty;
            $stock->unit_price = $updateUnitPrice;
            $stock->update();

        }else{
            Stock::create([
                'farm_id' => $vaccine->farm_id,
                'product_id' => $vaccine->product_id,
                'quantity' => $vaccine->quantity,
                'unit_price' => $vaccine->unit_price,
            ]);
        }

        $vaccine->delete();
        toastr()->warning($vaccine->name.__('global.deleted_success'),__('global.vaccine').__('global.deleted'));
        return redirect()->route('admin.vaccines.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $vaccine = Vaccine::withTrashed()->find($id);
        $quantity = $vaccine->quantity ?? 0;
        $unit_price = $vaccine->unit_price ?? 0;
        $stock =  getStock($vaccine->farm_id,$vaccine->product_id);
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

        $vaccine->unit_price = $unit_price;
        $vaccine->quantity = $feedQTY;
        $vaccine->total_cost = $feedCost;

        if ($stock){
            $stock->quantity = $updateStockQty;
            $stock->unit_price = $updateStockUnitPrice;
            $stock->update();
        }

        $vaccine->deleted_at = null;
        $vaccine->update();
        toastr()->success($vaccine->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.vaccines.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $vaccine = Vaccine::withTrashed()->find($id);
        $vaccine->cattles()->detach();
        $vaccine->forceDelete();
        toastr()->error(__('global.vaccine').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.vaccines.trashed');
    }
    public function approve ($id){
        $vaccine = Vaccine::find($id);
        $vaccine->status = 'success';
        $vaccine->update();
        toastr()->success($vaccine->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.vaccines.index');
    }
}

