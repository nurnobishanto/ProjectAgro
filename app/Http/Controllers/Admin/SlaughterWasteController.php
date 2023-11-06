<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SlaughterCustomer;
use App\Models\SlaughterCustomerReceive;
use App\Models\SlaughterWaste;
use App\Models\SlaughterStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SlaughterWasteController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $slaughter_wastes =SlaughterWaste::orderBy('id','DESC')->get();
        return view('admin.slaughter_wastes.index',compact('slaughter_wastes'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
        ]);
        App::setLocale(session('locale'));
        $store_id = $request->store_id;
        return view('admin.slaughter_wastes.create',compact(['store_id']));
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $slaughter_waste = SlaughterWaste::find($id);
        return view('admin.slaughter_wastes.edit',compact('slaughter_waste'));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_waste = SlaughterWaste::find($id);
        return view('admin.slaughter_wastes.show',compact('slaughter_waste'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:slaughter_wastes',
            'date' => 'required',
            'store_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
        ]);

        $slaughter_waste = SlaughterWaste::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'slaughter_store_id' => $request->store_id,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $total = 0;
        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $product_prices = $request->input('product_prices');

            $dataToInsert = [];
            foreach ($product_ids as $i => $productId) {
                $quantity = $product_quantities[$i];
                $price = $product_prices[$i];
                $total += ($quantity * $price);
                $dataToInsert[$productId] = [
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity * $price,
                ];
            }
            $slaughter_waste->products()->sync($dataToInsert);
        }
        toastr()->success($slaughter_waste->invoice_no.__('global.created_success'),__('global.slaughter_waste').__('global.created'));
        return redirect()->route('admin.slaughter_wastes.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:slaughter_wastes,id,'.$id,
            'date' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
        ]);
        // Find the SlaughterWaste record to update
        $slaughter_waste = SlaughterWaste::findOrFail($id);

        // Update the fields of the SlaughterWaste record
        $slaughter_waste->update([
            'date' => $request->date,
            'note' => $request->note,
            'updated_by' => auth()->user()->id,
        ]);
        $total = 0;
        // Update the related products
        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $product_prices = $request->input('product_prices');

            $dataToSync = [];
            foreach ($product_ids as $i => $productId) {
                $quantity = $product_quantities[$i];
                $price = $product_prices[$i];
                $total += ($quantity * $price);
                $dataToSync[$productId] = [
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity * $price,
                ];
            }
            $slaughter_waste->products()->sync($dataToSync);
        } else {
            // If no products are provided, you may consider detaching all existing products from the waste
            $slaughter_waste->products()->detach();
        }

        toastr()->success($slaughter_waste->invoice_no.__('global.updated_success'),__('global.slaughter_waste').__('global.updated'));
        return redirect()->route('admin.slaughter_wastes.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_waste = SlaughterWaste::find($id);
        $slaughter_waste->delete();
        toastr()->warning($slaughter_waste->invoice_no.__('global.deleted_success'),__('global.slaughter_waste').__('global.deleted'));
        return redirect()->route('admin.slaughter_wastes.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughter_wastes = SlaughterWaste::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughter_wastes.trashed',compact('slaughter_wastes'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter_waste = SlaughterWaste::withTrashed()->find($id);
        $slaughter_waste->deleted_at = null;
        $slaughter_waste->update();
        toastr()->success($slaughter_waste->invoice_no.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughter_wastes.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter_waste = SlaughterWaste::withTrashed()->find($id);
        $slaughter_waste->forceDelete();
        toastr()->error(__('global.slaughter_waste').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughter_wastes.trashed');
    }
    public function approve(Request $request,$id){
        $slaughter_waste = SlaughterWaste::find($id);
        foreach ($slaughter_waste->products as $product) {
            $stock = SlaughterStock::where('slaughter_store_id', $slaughter_waste->slaughter_store_id)
                ->where('product_id', $product->id)
                ->first();

            if ($stock) {
                $preQty = $stock->quantity;
                $newQty = $product->pivot->quantity;
                $updateQty = min($newQty, $preQty);

                if ($updateQty > 0) {
                    $stock->decrement('quantity', $updateQty);
                    $product->pivot->quantity = $updateQty;
                    $product->save();
                } else {
                    // Detach the product if quantity is zero
                    $slaughter_waste->products()->detach($product);
                }
            } else {
                $slaughter_waste->products()->detach($product);
            }
        }
        $slaughter_waste->status = 'success';
        $slaughter_waste->update();

        toastr()->success(__('notification.slaughter_waste_has_been_approved'));
        return redirect()->back();
    }

}
