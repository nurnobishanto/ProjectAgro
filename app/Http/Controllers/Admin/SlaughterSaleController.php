<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\SlaughterCustomer;
use App\Models\SlaughterCustomerReceive;
use App\Models\SlaughterSale;

use App\Models\SlaughterStock;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SlaughterSaleController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $slaughter_sales =SlaughterSale::orderBy('id','DESC')->get();
        return view('admin.slaughter_sales.index',compact('slaughter_sales'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
        ]);
        App::setLocale(session('locale'));
        $store_id = $request->store_id;
        return view('admin.slaughter_sales.create',compact(['store_id']));
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $slaughter_sale = SlaughterSale::find($id);
        return view('admin.slaughter_sales.edit',compact('slaughter_sale'));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_sale = SlaughterSale::find($id);
        return view('admin.slaughter_sales.show',compact('slaughter_sale'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:slaughter_sales',
            'date' => 'required',
            'store_id' => 'required',
            'slaughter_customer_id' => 'required',
            'account_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
        ]);

        $slaughter_sale = SlaughterSale::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'slaughter_customer_id' => $request->slaughter_customer_id,
            'slaughter_store_id' => $request->store_id,
            'tax' => $request->tax,
            'account_id' => $request->account_id,
            'discount' => $request->discount??0,
            'paid' => $request->paid_amount??0,
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
            $slaughter_sale->products()->sync($dataToInsert);
        }

        $taxAmount = ($slaughter_sale->tax / 100) * $total;
        $grand_total = $total + ($taxAmount - $slaughter_sale->discount);
        $due = $grand_total - $slaughter_sale->paid;

        $slaughter_sale->total = $total;
        $slaughter_sale->grand_total = $grand_total;
        $slaughter_sale->due = $due;
        $slaughter_sale->update();

        toastr()->success($slaughter_sale->unique_id.__('global.created_success'),__('global.slaughter_sale').__('global.created'));
        return redirect()->route('admin.slaughter_sales.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:slaughter_sales,id,'.$id,
            'date' => 'required',
            'slaughter_customer_id' => 'required',
            'account_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
        ]);
        // Find the SlaughterSale record to update
        $slaughter_sale = SlaughterSale::findOrFail($id);

        // Update the fields of the SlaughterSale record
        $slaughter_sale->update([
            'date' => $request->date,
            'slaughter_customer_id' => $request->slaughter_customer_id,
            'tax' => $request->tax,
            'account_id' => $request->account_id,
            'discount' => $request->discount ?? 0,
            'paid' => $request->paid_amount ?? 0,
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
            $slaughter_sale->products()->sync($dataToSync);
        } else {
            // If no products are provided, you may consider detaching all existing products from the sale
            $slaughter_sale->products()->detach();
        }
        $taxPercentage = $slaughter_sale->tax;
        $taxAmount = ($taxPercentage / 100) * $total;
        $grand_total = $total + ($taxAmount - $slaughter_sale->discount);
        $due = $grand_total - $slaughter_sale->paid;

        $slaughter_sale->total = $total;
        $slaughter_sale->grand_total = $grand_total;
        $slaughter_sale->due = $due;
        $slaughter_sale->update();

        toastr()->success($slaughter_sale->unique_id.__('global.updated_success'),__('global.slaughter_sale').__('global.updated'));
        return redirect()->route('admin.slaughter_sales.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_sale = SlaughterSale::find($id);
        $slaughter_sale->delete();
        toastr()->warning($slaughter_sale->unique_id.__('global.deleted_success'),__('global.slaughter_sale').__('global.deleted'));
        return redirect()->route('admin.slaughter_sales.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughter_sales = SlaughterSale::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughter_sales.trashed',compact('slaughter_sales'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter_sale = SlaughterSale::withTrashed()->find($id);
        $slaughter_sale->deleted_at = null;
        $slaughter_sale->update();
        toastr()->success($slaughter_sale->unique_id.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughter_sales.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter_sale = SlaughterSale::withTrashed()->find($id);
        $slaughter_sale->forceDelete();
        toastr()->error(__('global.slaughter_sale').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughter_sales.trashed');
    }
    public function approve(Request $request,$id){
        $slaughter_sale = SlaughterSale::find($id);

        foreach ($slaughter_sale->products as $product) {
            $stock = SlaughterStock::where('slaughter_store_id', $slaughter_sale->slaughter_store_id)
                ->where('product_id', $product->id)
                ->first();
            if (!$stock || $product->pivot->quantity > $stock->quantity) {
                toastr()->error($product->name, __('global.stock_out'));
                return redirect()->back();
            }
        }

        $customer = SlaughterCustomer::find($slaughter_sale->slaughter_customer_id);
        $account = Account::find($slaughter_sale->account_id);

        SlaughterCustomerReceive::create([
            'unique_id' => generateInvoiceId('SCR',\App\Models\SlaughterCustomerReceive::class,'unique_id'),
            'date' =>$slaughter_sale->date,
            'slaughter_customer_id' =>$slaughter_sale->slaughter_customer_id,
            'account_id' =>$slaughter_sale->account_id,
            'amount' =>$slaughter_sale->paid,
            'type' => 'receive',
            'note' =>'Payment at Slaughter Sale for '.$slaughter_sale->unique_id,
            'status' => 'success',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        $account->current_balance = $account->current_balance - $slaughter_sale->paid;
        $account->update();

        $customer->balance = $customer->balance - $slaughter_sale->due;
        $customer->update();

        $slaughter_sale->status = 'success';
        $slaughter_sale->update();

        toastr()->success(__('notification.slaughter_sale_has_been_approved'));
        return redirect()->back();
    }

}
