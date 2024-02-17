<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AssignedCost;
use App\Models\ExpenseCategory;
use App\Models\Farm;
use App\Models\Party;
use App\Models\PartyReceive;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class SaleController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $sales = Sale::orderBy('id','DESC')->get();
        return view('admin.sales.index',compact('sales'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farm_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.sales.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $data = array();
        $data['farm'] = Farm::find($request->farm_id);
        return view('admin.sales.create',$data);
    }
    public function edit($id)
    {
        App::setLocale(session('locale'));
        $sale = Sale::find($id);
        return view('admin.sales.edit',compact('sale'));
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $sale = Sale::find($id);
        return view('admin.sales.show',compact('sale'));
    }
    public function store(Request $request){
        App::setLocale(session('locale'));
        $request->validate([
            'invoice_no' => 'required|unique:sales',
            'sale_date' => 'required',
            'party_id' => 'required',
            'farm_id' => 'required',
            'account_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        $imageFile = null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('sale-image');
        }
        $sale = Sale::create([
            'invoice_no' => $request->invoice_no,
            'sale_date' => $request->sale_date,
            'party_id' => $request->party_id,
            'farm_id' => $request->farm_id,
            'tax' => $request->tax,
            'account_id' => $request->account_id,
            'discount' => $request->discount??0,
            'shipping_cost' => $request->shipping_cost??0,
            'labor_cost' => $request->labor_cost??0,
            'other_cost' => $request->other_cost??0,
            'paid' => $request->paid_amount??0,
            'sale_note' => $request->sale_note,
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
                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity*$price,
                ]);
            }
        }
        toastr()->success($sale->invoice_no.__('global.created_success'),__('global.sale').__('global.created'));
        return redirect()->route('admin.sales.index');
    }
    public function update(Request $request, $id){
        App::setLocale(session('locale'));
        $request->validate([
            'invoice_no' => 'required|unique:sales,id,'.$id,
            'sale_date' => 'required',
            'party_id' => 'required',
            'farm_id' => 'required',
            'account_id' => 'required',
            'product_ids' => 'required',
            'product_quantities' => 'required',
            'product_prices' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);
        $sale = Sale::find($id);
        $imageFile = $sale->image??null;
        if($request->file('image')){
            $imageFile = $request->file('image')->store('sale-image');
            $old_image_path = "uploads/".$sale->image;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $sale->invoice_no =  $request->invoice_no;
        $sale->sale_date =  $request->sale_date;
        $sale->party_id =  $request->party_id;
        $sale->farm_id =  $request->farm_id;
        $sale->account_id =  $request->account_id;
        $sale->tax =  $request->tax??0;
        $sale->discount =  $request->discount??0;
        $sale->shipping_cost =  $request->shipping_cost??0;
        $sale->labor_cost =  $request->labor_cost??0;
        $sale->other_cost =  $request->other_cost??0;
        $sale->paid =  $request->paid_amount??0;
        $sale->sale_note =  $request->sale_note;
        $sale->image = $imageFile;
        $sale->updated_by = auth()->user()->id;
        $sale->update();
        $sale->saleProducts()->delete();

        if ($request->has('product_ids')) {
            $product_ids = $request->input('product_ids');
            $product_quantities = $request->input('product_quantities');
            $product_prices = $request->input('product_prices');
            for ($i = 0 ;$i < sizeof($product_ids);$i++){
                $productId = $product_ids[$i];
                $quantity = $product_quantities[$i];
                $price = $product_prices[$i];
                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'sub_total' => $quantity*$price,
                ]);
            }
        }
        toastr()->success($sale->invoice_no.__('global.updated_success'),__('global.sale').__('global.updated'));
        return redirect()->route('admin.sales.index');
    }
    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $sale = Sale::find($id);
        $sale->delete();
        toastr()->warning($sale->invoice_no.__('global.deleted_success'),__('global.sale').__('global.deleted'));
        return redirect()->route('admin.sales.index');
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $sales = Sale::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.sales.trashed',compact('sales'));
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $sale = Sale::withTrashed()->find($id);
        $sale->deleted_at = null;
        $sale->update();
        toastr()->success($sale->invoice_no.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.sales.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $sale = Sale::withTrashed()->find($id);
        $old_image_path = "uploads/".$sale->image;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $sale->forceDelete();
        toastr()->error(__('global.sale').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.sales.trashed');
    }
    public function approve(Request $request,$id){
        $sale = Sale::find($id);

        $totalSaleQty = $sale->saleProducts->sum('quantity');
        $totalSalePrice = $sale->saleProducts->sum('sub_total');
        $taxAmount =round($totalSalePrice * ($sale->tax /100 ),2) ;
        $cost = ($sale->shipping_cost + $sale->labor_cost + $sale->other_cost + $taxAmount) - $sale->discount;
        $costPerQty = round(($cost/$totalSaleQty),2);

        $paid = $sale->paid;
        $due = ($totalSalePrice + $cost) - $paid;

        foreach ($sale->saleProducts as $pp){
            $stock = Stock::where('farm_id',$sale->farm_id)->where('product_id',$pp->product_id)->first();

            if ($stock){
                $preQty = $stock->quantity;
//                $preUnitPrice = $stock->unit_price;
//                $preBalance = $preQty * $preUnitPrice;

                $newQty = $pp->quantity;
//                $newUnitPrice = $pp->unit_price + $costPerQty;
//                $newBalance = $newQty * $newUnitPrice;

//                $updateBalance = $preBalance - $newBalance;
                $updateQty =  $preQty - $newQty;
//                $updateUnitPrice = round(($updateBalance/$updateQty),2);

                $stock->quantity = $updateQty;
//                $stock->unit_price = $updateUnitPrice;
                $stock->update();

            }else{
                Stock::create([
                    'farm_id' => $sale->farm_id,
                    'product_id' => $pp->product_id,
                    'quantity' => $pp->quantity * -1,
                    'unit_price' => $pp->unit_price + $costPerQty,
                ]);
            }
        }
        $sale->status = 'success';
        $sale->due = $due;
        $sale->update();


        $party = Party::find($sale->party_id);
        $account = Account::find($sale->account_id);

        PartyReceive::create([
            'unique_id' => generateInvoiceId('PRSP',\App\Models\PartyReceive::class,'unique_id'),
            'date' =>$sale->sale_date,
            'party_id' =>$sale->party_id,
            'account_id' =>$sale->account_id,
            'amount' =>$sale->paid,
            'type' =>'receive',
            'note' =>'Received at Sale for '.$sale->invoice_no,
            'status' => 'success',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        $expense_category = ExpenseCategory::where('name','Sale Expense')->first();

//        if (!$expense_category){
//            $expense_category = ExpenseCategory::create([
//                'name' => 'Sale Expense',
//                'status' => 'activate'
//            ]);
//        }
        //Need to assign expense and then attach into assign-cost
//        AssignedCost::create([
//            'date' => $sale->sale_date,
//            'model' => 'Sale',
//            'model_id' => $id,
//            'amount' => $cost,
//        ]);
        $account->current_balance = $account->current_balance + ($sale->paid - $cost);
        $account->update();

        $party->current_balance = $party->current_balance + $sale->due;
        $party->update();

        toastr()->success('Sale has been approved ');
        return redirect()->route('admin.stock');
    }


}
