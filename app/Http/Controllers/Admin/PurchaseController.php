<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $purchases = Purchase::orderBy('id','DESC')->get();
        return view('admin.purchases.index',compact('purchases'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.purchases.create');
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $purchase = Purchase::find($id);
        return view('admin.purchases.edit',compact('purchase'));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $purchase = Purchase::find($id);
        return view('admin.purchases.show',compact('purchase'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'invoice_no' => 'required|unique:purchases',
            'purchase_date' => 'required',
            'supplier_id' => 'required',
            'farm_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        $imageFile = null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('purchase-image');
        }
        $purchase = Purchase::create([
            'invoice_no' => $request->invoice_no,
            'purchase_date' => $request->purchase_date,
            'supplier_id' => $request->supplier_id,
            'farm_id' => $request->farm_id,
            'tax' => $request->tax,
            'discount' => $request->discount??0,
            'shipping_cost' => $request->shipping_cost??0,
            'labor_cost' => $request->labor_cost??0,
            'other_cost' => $request->other_cost??0,
            'paid' => $request->paid_amount??0,
            'purchase_note' => $request->purchase_note,
            'image' => $imageFile,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $product_prices = $request->input('product_prices');
            for ($i = 0 ;$i < sizeof($product_ids);$i++){
                $productId = $product_ids[$i];
                $quantity = $product_quantities[$i];
                $price = $product_prices[$i];
                PurchaseProduct::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity*$price,
                ]);
            }
        }
        toastr()->success($purchase->invoice_no.__('global.created_success'),__('global.purchase').__('global.created'));
        return redirect()->route('admin.purchases.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'invoice_no' => 'required|unique:purchases,id,'.$id,
            'purchase_date' => 'required',
            'supplier_id' => 'required',
            'farm_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        $purchase = Purchase::find($id);
        $imageFile = $purchase->image??null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('purchase-image');
            $old_image_path = "uploads/".$purchase->image;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $purchase->invoice_no =  $request->invoice_no;
        $purchase->purchase_date =  $request->purchase_date;
        $purchase->supplier_id =  $request->supplier_id;
        $purchase->farm_id =  $request->farm_id;
        $purchase->tax =  $request->tax??0;
        $purchase->discount =  $request->discount??0;
        $purchase->shipping_cost =  $request->shipping_cost??0;
        $purchase->labor_cost =  $request->labor_cost??0;
        $purchase->other_cost =  $request->other_cost??0;
        $purchase->paid =  $request->paid_amount??0;
        $purchase->purchase_note =  $request->purchase_note;
        $purchase->image = $imageFile;
        $purchase->updated_by = auth()->user()->id;
        $purchase->update();
        $purchase->purchaseProducts()->delete();

        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $product_prices = $request->input('product_prices');
            for ($i = 0 ;$i < sizeof($product_ids);$i++){
                $productId = $product_ids[$i];
                $quantity = $product_quantities[$i];
                $price = $product_prices[$i];
                PurchaseProduct::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity*$price,
                ]);
            }
        }
        toastr()->success($purchase->invoice_no.__('global.updated_success'),__('global.purchase').__('global.updated'));
        return redirect()->route('admin.purchases.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $purchase = Purchase::find($id);
        $purchase->delete();
        toastr()->warning($purchase->invoice_no.__('global.deleted_success'),__('global.purchase').__('global.deleted'));
        return redirect()->route('admin.purchases.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $purchases = Purchase::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.purchases.trashed',compact('purchases'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $purchase = Purchase::withTrashed()->find($id);
        $purchase->deleted_at = null;
        $purchase->update();
        toastr()->success($purchase->invoice_no.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.purchases.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $purchase = Purchase::withTrashed()->find($id);
        $old_image_path = "uploads/".$purchase->image;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $purchase->forceDelete();
        toastr()->error(__('global.purchase').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.purchases.trashed');
    }
    public function approve(Request $request,$id){
        $purchase = Purchase::find($id);

        $totalPurchaseQty = $purchase->purchaseProducts->sum('quantity');
        $totalPurchasePrice = $purchase->purchaseProducts->sum('sub_total');
        $taxAmount =round($totalPurchasePrice * ($purchase->tax /100 ),2) ;
        $cost = ($purchase->shipping_cost + $purchase->labor_cost + $purchase->other_cost + $taxAmount) - $purchase->discount;
        $costPerQty = round(($cost/$totalPurchaseQty),2);

        $paid = $purchase->paid;
        $due = ($totalPurchasePrice + $cost) - $paid;

        foreach ($purchase->purchaseProducts as $pp){
            $stock = Stock::where('farm_id',$purchase->farm_id)->where('product_id',$pp->product_id)->first();

            if ($stock){
                $preQty = $stock->quantity;
                $preUnitPrice = $stock->unit_price;
                $preBalance = $preQty * $preUnitPrice;

                $newQty = $pp->quantity;
                $newUnitPrice = $pp->unit_price + $costPerQty;
                $newBalance = $newQty * $newUnitPrice;

                $updateBalance = $preBalance + $newBalance;
                $updateQty = $newQty + $preQty;
                $updateUnitPrice = round(($updateBalance/$updateQty),2);

                $stock->quantity = $updateQty;
                $stock->unit_price = $updateUnitPrice;
                $stock->update();

            }else{
                Stock::create([
                    'farm_id' => $purchase->farm_id,
                    'product_id' => $pp->product_id,
                    'quantity' => $pp->quantity,
                    'unit_price' => $pp->unit_price + $costPerQty,
                ]);
            }
        }
        $purchase->status = 'success';
        $purchase->due = $due;
        $purchase->update();
        $supplier =  Supplier::find($purchase->supplier_id);
        $supplier->current_balance = $supplier->current_balance - $purchase->due;
        $supplier->update();
        toastr()->success('Purchase has been approved ');
        return redirect()->route('admin.stock');
    }

    public function stock(Request $request){
        $stocks = Stock::all();
        $farm_id = $request->farm_id??0;
        $product_id = $request->product_id??0;

        if ($request->farm_id){
            $stocks = $stocks->where('farm_id',$request->farm_id);
        }
        if ($request->product_id){
            $stocks = $stocks->where('product_id',$request->product_id);
        }
        $totalBalance = 0;
        foreach ($stocks as $stock){
            $totalBalance += $stock->quantity * $stock->unit_price;
        }
        return view('admin.purchases.stock',compact(['stocks','product_id','farm_id','totalBalance']));
    }
}
