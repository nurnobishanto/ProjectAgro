<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $purchase = Purchase::find($id);
        return view('admin.purchases.show',compact('purchase'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'invoice_no' => 'required',
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
}
