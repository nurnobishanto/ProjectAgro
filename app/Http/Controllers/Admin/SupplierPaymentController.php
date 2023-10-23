<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class SupplierPaymentController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $supplier_payments = SupplierPayment::orderBy('id','DESC')->get();
        return view('admin.supplier_payments.index',compact('supplier_payments'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $supplier_payments = SupplierPayment::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.supplier_payments.trashed',compact('supplier_payments'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.supplier_payments.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'supplier_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        SupplierPayment::create([
            'unique_id' =>$request->unique_id,
            'date' =>$request->date,
            'supplier_id' =>$request->supplier_id,
            'account_id' =>$request->account_id,
            'amount' =>$request->amount,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.supplier_payment').__('global.created'));
        return redirect()->route('admin.supplier-payments.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::find($id);
        return view('admin.supplier_payments.show',compact('supplier_payment'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::find($id);
        return view('admin.supplier_payments.edit',compact(['supplier_payment']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::find($id);
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'supplier_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $supplier_payment->unique_id = $request->unique_id;
        $supplier_payment->date = $request->date;
        $supplier_payment->account_id = $request->account_id;
        $supplier_payment->supplier_id = $request->supplier_id;
        $supplier_payment->amount = $request->amount;
        $supplier_payment->note = $request->note;
        $supplier_payment->status = 'pending';
        $supplier_payment->updated_by = auth()->user()->id;
        $supplier_payment->update();
        toastr()->success($supplier_payment->name.__('global.updated_success'),__('global.supplier_payment').__('global.updated'));
        return redirect()->route('admin.supplier-payments.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::find($id);
        $supplier_payment->delete();
        toastr()->warning($supplier_payment->name.__('global.deleted_success'),__('global.supplier_payment').__('global.deleted'));
        return redirect()->route('admin.supplier-payments.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::withTrashed()->find($id);
        $supplier_payment->deleted_at = null;
        $supplier_payment->update();
        toastr()->success($supplier_payment->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.supplier-payments.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $supplier_payment = SupplierPayment::withTrashed()->find($id);
        $supplier_payment->forceDelete();
        toastr()->error(__('global.supplier_payment').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.supplier-payments.trashed');
    }

    public function approve ($id){
        $sp = SupplierPayment::find($id);

        if ($sp->status != 'success'){
            $account = $sp->account;
            $supplier = $sp->supplier;

            $account->current_balance = $account->current_balance - $sp->amount;
            $account->update();

            $supplier->current_balance = $supplier->current_balance - $sp->amount;
            $supplier->update();

            $sp->status = 'success';
            $sp->update();
        }
        toastr()->success($sp->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.supplier-payments.index');
    }

}
