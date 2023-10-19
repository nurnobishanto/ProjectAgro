<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\FeedingGroup;
use App\Models\Product;
use App\Models\Treatment;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class TreatmentController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));

        $treatments = Treatment::orderBy('id','DESC')->get();
        if ($request->date){
            $treatments = $treatments->where('date',$request->date);
        }
        if ($request->status){
            $treatments = $treatments->where('status',$request->status);
        }
        if ($request->updated_by){
            $treatments = $treatments->where('updated_by',$request->updated_by);
        }
        if ($request->created_by){
            $treatments = $treatments->where('created_by',$request->created_by);
        }
        if ($request->farm_id){
            $treatments = $treatments->where('farm_id',$request->farm_id);
        }
        if ($request->product_id){
            $treatments = $treatments->where('product_id',$request->product_id);
        }
        if ($request->cattle_id){
            $treatments = $treatments->where('cattle_id',$request->cattle_id);
        }
        $products =  Product::where('type','cattle_medicine')->where('status','active')->get();
        return view('admin.treatments.index',compact(['treatments','products']));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $treatments = Treatment::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.treatments.trashed',compact('treatments'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_id' => 'required',
            'products' => 'required',
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.treatments.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $data = array();
        $data['cattle'] = Cattle::where('id',$request->tag_id)->first();;
        $data['products'] = Product::whereIn('id',$request->products)->where('status','active')->get();
        return view('admin.treatments.create',$data);
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'doctor' => 'required',
            'tag_id' => 'required',
            'farm_id' => 'required',
            'disease' => 'required',
            'items' => 'required',
        ]);

        $treatment = Treatment::where('date',$request->date)
            ->where('cattle_id',$request->tag_id)
            ->first();

        if (!$treatment){
            $total_cost = 0;

            $treatment = Treatment::create([
                'date' => $request->date,
                'farm_id' => $request->farm_id,
                'doctor' => $request->doctor,
                'disease' => $request->disease,
                'comment' => $request->comment,
                'cattle_id' => $request->tag_id,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            $items = [];
            foreach ($request->items as $key => $item_id) {
                $quantity = $request->qty[$key] ?? 0;
                $stock  =  getStock($treatment->farm_id,$item_id);
                $stkQTY = 0;
                $stkPrice = 0;
                if ($stock){
                    $stkQTY = $stock->quantity;
                    $stkPrice = $stock->unit_price;
                }
                $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
                $feedCost = Round(($feedQTY * $stkPrice),2);
                $total_cost += $feedCost;
                $items[] = [
                    'product_id' => $item_id,
                    'unit_price' => $stkPrice,
                    'quantity' => $feedQTY,
                    'total_cost' => $feedCost,
                ];
                if ($stock){
                    $stock->quantity = $stkQTY - $feedQTY;
                    $stock->update();
                }

            }
            $treatment->products()->sync($items);
            $treatment->cost = $total_cost;
            $treatment->update();

            toastr()->success(__('global.created_success'),__('global.treatment').__('global.created'));
        }else{
            toastr()->warning(__('global.created_success'),__('global.treatment').__('global.created'));
        }
        return redirect()->route('admin.treatments.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $data = array();
        $data['treatment'] = Treatment::find($id);

        return view('admin.treatments.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $treatment = Treatment::find($id);
        $data = array();
        $data['treatment'] = $treatment;
        $data['cattle'] = $treatment->cattle;
        $data['products'] = $treatment->products??[];

        return view('admin.treatments.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));

        $request->validate([
            'doctor' => 'required',
            'tag_id' => 'required',
            'farm_id' => 'required',
            'disease' => 'required',
            'items' => 'required',
        ]);
        $treatment = Treatment::find($id);
        $treatment->comment = $request->comment;
        $treatment->doctor = $request->doctor;
        $treatment->disease = $request->disease;
        $treatment->updated_by = auth()->user()->id;
        $treatment->update();

        $items = [];
        $total_cost = 0;
        foreach ($request->items as $key => $item_id) {
            $quantity = $request->qty[$key] ?? 0;
            $stock  =  getStock($treatment->farm_id,$item_id);
            $stkQTY = 0;
            $stkPrice = 0;
            if ($stock){
                $stkQTY = $stock->quantity + (getTreatmentProduct($treatment->id,$item_id)->quantity??0);
                $stkPrice = $stock->unit_price;
            }
            $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
            $feedCost = Round(($feedQTY * $stkPrice),2);
            $total_cost += $feedCost;
            $items[] = [
                'product_id' => $item_id,
                'unit_price' => $stkPrice,
                'quantity' => $feedQTY,
                'total_cost' => $feedCost,
            ];
            if ($stock){
                $stock->quantity = $stkQTY - $feedQTY;
                $stock->update();
            }

        }
        $treatment->products()->detach();
        $treatment->products()->sync($items);
        $treatment->cost = $total_cost;
        $treatment->update();

        toastr()->success(__('global.updated_success'),__('global.treatment').__('global.updated'));
        return redirect()->route('admin.treatments.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $treatment = Treatment::find($id);
        $products = $treatment->products;

        foreach ($products as $product){
            $stock = Stock::where('farm_id',$treatment->farm_id)->where('product_id',$product->id)->first();
            if ($stock){
                $preQty = $stock->quantity;
                $preUnitPrice = $stock->unit_price;
                $preBalance = $preQty * $preUnitPrice;

                $newQty = $product->pivot->quantity;
                $newUnitPrice =  $product->pivot->unit_price;
                $newBalance = $newQty * $newUnitPrice;

                $updateBalance = $preBalance + $newBalance;
                $updateQty = $newQty + $preQty;

                $updateUnitPrice = $updateQty?round(($updateBalance/$updateQty),2):0;

                $stock->quantity = $updateQty;
                $stock->unit_price = $updateUnitPrice;
                $stock->update();

            }else{
                Stock::create([
                    'farm_id' => $treatment->farm_id,
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => $product->pivot->unit_price,
                ]);
            }
        }
        $treatment->delete();
        toastr()->warning($treatment->name.__('global.deleted_success'),__('global.treatment').__('global.deleted'));
        return redirect()->route('admin.treatments.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $treatment = Treatment::withTrashed()->find($id);

        $total_cost = 0;
        $items = [];
        foreach ($treatment->products as  $product) {
            $unit_price = $product->pivot->unit_price ?? 0;
            $quantity = $product->pivot->quantity ?? 0;

            $stock  =  getStock($treatment->farm_id,$product->id);
            $stkQTY = 0;
            $stkUnitPrice = 0;
            $stockTotal = 0;

            if ($stock){
                $stkQTY = $stock->quantity ;
                $stkUnitPrice = $stock->unit_price;
                $stockTotal = $stkQTY * $stkUnitPrice;
            }

            $feedQTY = ($quantity<=$stkQTY)?$quantity:$stkQTY;
            $feedCost = Round(($feedQTY * $unit_price),2);
            //$feedCost = Round(($feedQTY * $stkUnitPrice),2);


            $updateStockQty  = $stkQTY - $feedQTY;
            $updateStockTotal  = $stockTotal - $feedCost;
            $updateStockUnitPrice  = $updateStockQty?round(($updateStockTotal / $updateStockQty),2):0;

            $total_cost += $feedCost;
            $items[] = [
                'product_id' => $product->id,
                'unit_price' => $unit_price,
                'quantity' => $feedQTY,
                'total_cost' => $feedCost,
            ];
            if ($stock){
                $stock->quantity = $updateStockQty;
                $stock->unit_price = $updateStockUnitPrice;
                $stock->update();
            }

        }
        $treatment->products()->detach();
        $treatment->products()->sync($items);
        $treatment->deleted_at = null;
        $treatment->update();
        toastr()->success($treatment->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.treatments.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $treatment = Treatment::withTrashed()->find($id);
        $treatment->products()->detach();
        $treatment->forceDelete();
        toastr()->error(__('global.treatment').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.treatments.trashed');
    }
    public function approve ($id){
        $treatment = Treatment::find($id);
        $treatment->status = 'success';
        $treatment->update();
        toastr()->success($treatment->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.treatments.index');
    }

}
