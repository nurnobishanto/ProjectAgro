<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\MilkPartyReceive;
use App\Models\MilkSale;
use App\Models\MilkSaleParty;
use App\Models\MilkStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MilkSaleController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $milk_sales = MilkSale::orderBy('id','DESC')->get();
        return view('admin.milk_sales.index',compact('milk_sales'));
    }
    public function create(Request $request)
    {
        $request->validate([
            'farm_id' => 'required',
        ]);
        App::setLocale(session('locale'));
        $farm_id = $request->farm_id;
        $stock = MilkStock::where('farm_id',$farm_id)->first();
        return view('admin.milk_sales.create',compact(['farm_id','stock']));
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $milk_sale = MilkSale::find($id);
        $stock = MilkStock::where('farm_id',$milk_sale->farm_id)->first();
        return view('admin.milk_sales.edit',compact(['milk_sale','stock']));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale = MilkSale::find($id);
        return view('admin.milk_sales.show',compact('milk_sale'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:milk_sales',
            'date' => 'required',
            'farm_id' => 'required',
            'milk_sale_party_id' => 'required',
            'account_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        // Perform calculations
        $quantity = $request->quantity ?? 0;
        $unit_price = $request->unit_price ?? 0;
        $sub_total = $unit_price * $quantity;
        $discount = $request->discount ?? 0;
        $paid_amount = $request->paid_amount ?? 0;
        $tax = $request->tax;

        $taxAmount = ($tax / 100) * $sub_total;
        $grand_total = $sub_total + ($taxAmount - $discount);
        $due = $grand_total - $paid_amount;

        $milk_sale = MilkSale::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'milk_sale_party_id' => $request->milk_sale_party_id,
            'farm_id' => $request->farm_id,
            'tax' => $tax,
            'account_id' => $request->account_id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'sub_total' => $sub_total,
            'discount' => $discount,
            'total' => $grand_total,
            'paid' => $paid_amount,
            'due' => $due,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        toastr()->success($milk_sale->unique_id.__('global.created_success'),__('global.milk_sale').__('global.created'));
        return redirect()->route('admin.milk-sales.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required|unique:milk_sales,id,'.$id,
            'date' => 'required',
            'milk_sale_party_id' => 'required',
            'account_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        // Perform calculations
        $quantity = $request->quantity ?? 0;
        $unit_price = $request->unit_price ?? 0;
        $sub_total = $unit_price * $quantity;
        $discount = $request->discount ?? 0;
        $paid_amount = $request->paid_amount ?? 0;
        $tax = $request->tax;

        $taxAmount = ($tax / 100) * $sub_total;
        $grand_total = $sub_total + ($taxAmount - $discount);
        $due = $grand_total - $paid_amount;

        // Find the MilkSale record to update
        $milk_sale = MilkSale::findOrFail($id);
        $milk_sale->unique_id = $request->unique_id;
        $milk_sale->date = $request->date;
        $milk_sale->milk_sale_party_id = $request->milk_sale_party_id;
        $milk_sale->account_id = $request->account_id;
        $milk_sale->quantity = $request->quantity;
        $milk_sale->unit_price = $request->unit_price;
        $milk_sale->sub_total = $sub_total;
        $milk_sale->tax = $request->tax;
        $milk_sale->discount = $request->discount;
        $milk_sale->total = $grand_total;
        $milk_sale->paid = $paid_amount;
        $milk_sale->due = $due;
        $milk_sale->note = $request->note;
        $milk_sale->updated_by = auth()->user()->id;
        $milk_sale->update();

        toastr()->success($milk_sale->unique_id.__('global.updated_success'),__('global.milk_sale').__('global.updated'));
        return redirect()->route('admin.milk-sales.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $milk_sale = MilkSale::find($id);
        $milk_sale->delete();
        toastr()->warning($milk_sale->unique_id.__('global.deleted_success'),__('global.milk_sale').__('global.deleted'));
        return redirect()->route('admin.milk-sales.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $milk_sales = MilkSale::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.milk_sales.trashed',compact('milk_sales'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $milk_sale = MilkSale::withTrashed()->find($id);
        $milk_sale->deleted_at = null;
        $milk_sale->update();
        toastr()->success($milk_sale->invoice_no.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.milk-sales.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $milk_sale = MilkSale::withTrashed()->find($id);
        $milk_sale->forceDelete();
        toastr()->error(__('global.milk_sale').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.milk-sales.trashed');
    }
    public function approve(Request $request,$id){
        $milk_sale = MilkSale::find($id);

        $stock = MilkStock::where('farm_id', $milk_sale->farm_id)->first();
        if ($stock) {
            $stockQty = $stock->quantity;
            $saleQty = $milk_sale->quantity;
            if ($stockQty >= $saleQty) {
                $stock->decrement('quantity', $saleQty);
                $milk_sale->save();

                $customer = MilkSaleParty::find($milk_sale->milk_sale_party_id);
                $account = Account::find($milk_sale->account_id);

                MilkPartyReceive::create([
                    'unique_id' => generateInvoiceId('MPR',\App\Models\MilkPartyReceive::class,'unique_id'),
                    'date' =>$milk_sale->date,
                    'milk_sale_party_id' =>$milk_sale->milk_sale_party_id,
                    'account_id' =>$milk_sale->account_id,
                    'amount' =>$milk_sale->paid,
                    'type' => 'receive',
                    'note' =>'Payment at Milk Sale for '.$milk_sale->unique_id,
                    'status' => 'success',
                    'created_by' =>auth()->user()->id,
                    'updated_by' =>auth()->user()->id,
                ]);

                $account->current_balance = $account->current_balance - $milk_sale->paid;
                $account->update();

                $customer->current_balance = $customer->current_balance - $milk_sale->due;
                $customer->update();

                $milk_sale->status = 'success';
                $milk_sale->update();

                toastr()->success(__('notification.milk_sale_has_been_approved'));
                return redirect()->back();

            }else{
                toastr()->error('Stock empty');
                return redirect()->back();
            }
        }else{
            toastr()->error('Stock empty');
            return redirect()->back();
        }
    }
}
