<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\FeedingGroup;
use App\Models\FeedingRecord;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class FeedingController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));

        $feedings = FeedingRecord::orderBy('id','DESC')->get();
        if ($request->date){
            $feedings = $feedings->where('date',$request->date);
        }
        if ($request->status){
            $feedings = $feedings->where('status',$request->status);
        }
        if ($request->updated_by){
            $feedings = $feedings->where('updated_by',$request->updated_by);
        }
        if ($request->created_by){
            $feedings = $feedings->where('created_by',$request->created_by);
        }
        if ($request->feeding_group_id){
            $feedings = $feedings->where('feeding_group_id',$request->feeding_group_id);
        }
        return view('admin.feedings.index',compact('feedings'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $feedings = FeedingRecord::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.feedings.trashed',compact('feedings'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feeding_group_id' => 'required',
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.feedings.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $data = array();

        $feeding_group = FeedingGroup::where('id',$request->feeding_group_id)->first();
        $feeding_category = $feeding_group->feeding_category;
        $data['feeding_group'] = $feeding_group;

        $data['items'] = $feeding_group->products??[];
        //$data['cattles'] = $feeding_category->cattle->where('farm_id',$request->farm_id)->where('cattle_type_id',$request->cattle_type_id)->where('status','active')->get();
        $data['cattles'] = $feeding_category->cattle()
            ->where('farm_id',$request->farm_id)
            ->where('cattle_type_id',$request->cattle_type_id)
            ->where('status','active')
            ->get();
        return view('admin.feedings.create',$data);
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'feeding_group_id' => 'required',
            'items' => 'required',
            'cattles' => 'required',
        ]);
        $feeding = FeedingRecord::where('date',$request->date)
            ->where('feeding_group_id',$request->feeding_group_id)
            ->first();

        if (!$feeding){
            $total_cost = 0;
            $feeding_group = FeedingGroup::find($request->feeding_group_id);
            $feeding = FeedingRecord::create([
                'date' => $request->date,
                'feeding_group_id' => $request->feeding_group_id,
                'comment' => $request->comment,
                'status' => 'pending',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
            $items = [];
            foreach ($request->items as $key => $item_id) {
                $quantity = $request->qty[$key] ?? 0;
                $stock  =  getStock($feeding_group->farm_id,$item_id);
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
            $feeding->products()->sync($items);
            $feeding->cattles()->sync($request->cattles);
            $feeding->total_cost = $total_cost;
            $feeding->per_cattle_cost = Round(($total_cost /  $feeding->cattles->count()),2);
            $feeding->update();
            toastr()->success(__('global.created_success'),__('global.feeding').__('global.created'));
        }else{
            toastr()->warning(__('global.created_success'),__('global.feeding').__('global.created'));
        }
        return redirect()->route('admin.feedings.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $feeding = FeedingRecord::find($id);
        $data = array();

        $feeding_group = FeedingGroup::where('id',$feeding->feeding_group_id)->first();
        $feeding_category = $feeding_group->feeding_category;
        $data['feeding_group'] = $feeding_group;
        $data['feeding'] = $feeding;
        $data['items'] = $feeding_group->products??[];
        $data['cattles'] = $feeding_category->cattle()
            ->where('farm_id',$feeding_group->farm_id)
            ->where('cattle_type_id',$feeding_group->cattle_type_id)
            ->where('status','active')
            ->get();

        return view('admin.feedings.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $feeding = FeedingRecord::find($id);
        $data = array();

        $feeding_group = FeedingGroup::where('id',$feeding->feeding_group_id)->first();
        $feeding_category = $feeding_group->feeding_category;
        $data['feeding_group'] = $feeding_group;
        $data['feeding'] = $feeding;
        $data['items'] = $feeding_group->products??[];
        $data['cattles'] = $feeding_category->cattle()
            ->where('farm_id',$feeding_group->farm_id)
            ->where('cattle_type_id',$feeding_group->cattle_type_id)
            ->where('status','active')
            ->get();
        return view('admin.feedings.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));

        $request->validate([
            'feeding_group_id' => 'required',
            'items' => 'required',
            'cattles' => 'required',
        ]);
        $feeding = FeedingRecord::find($id);
        $feeding_group = $feeding->feedingGroup;

        $feeding->comment = $request->comment;
        $feeding->updated_by = auth()->user()->id;
        $feeding->update();
        $items = [];
        $total_cost = 0;
        foreach ($request->items as $key => $item_id) {
            $quantity = $request->qty[$key] ?? 0;
            $stock  =  getStock($feeding_group->farm_id,$item_id);
            $stkQTY = 0;
            $stkPrice = 0;
            if ($stock){
                $stkQTY = $stock->quantity + (getFeedRecordProduct($feeding->id,$item_id)->quantity??0);
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
        $feeding->products()->detach();
        $feeding->products()->sync($items);
        $feeding->cattles()->detach();
        $feeding->cattles()->sync($request->cattles);
        $feeding->total_cost = $total_cost;
        $feeding->per_cattle_cost = Round(($total_cost /  $feeding->cattles->count()),2);
        $feeding->update();

        toastr()->success(__('global.updated_success'),__('global.feeding').__('global.updated'));
        return redirect()->route('admin.feedings.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $feeding = FeedingRecord::find($id);
        $products = $feeding->products;
        $group = $feeding->feedingGroup;

        foreach ($products as $product){
            $stock = Stock::where('farm_id',$group->farm_id)->where('product_id',$product->pivot->product_id)->first();
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
                    'farm_id' => $group->farm_id,
                    'product_id' => $product->pivot->product_id,
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => $product->pivot->unit_price,
                ]);
            }
        }
        $feeding->delete();
        toastr()->warning($feeding->name.__('global.deleted_success'),__('global.feeding').__('global.deleted'));
        return redirect()->route('admin.feedings.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $feeding = FeedingRecord::withTrashed()->find($id);
        $feeding_group = $feeding->feedingGroup;

        $items = [];
        $total_cost = 0;
        foreach ($feeding->products as $key => $product) {
            $quantity = $product->pivot->quantity ?? 0;
            $unit_price = $product->pivot->unit_price ?? 0;


            $stock  =  getStock($feeding_group->farm_id,$product->pivot->product_id);
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
                'product_id' => $product->pivot->product_id,
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
        $feeding->products()->detach();
        $feeding->products()->sync($items);
        $feeding->deleted_at = null;
        $feeding->update();
        toastr()->success($feeding->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.feedings.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $feeding = FeedingRecord::withTrashed()->find($id);
        $feeding->products()->detach();
        $feeding->cattles()->detach();
        $feeding->forceDelete();
        toastr()->error(__('global.feeding').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.feedings.trashed');
    }
    public function approve ($id){
        $feeding = FeedingRecord::find($id);
        $feeding->status = 'success';
        $feeding->update();
        toastr()->success($feeding->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.feedings.index');
    }

}
