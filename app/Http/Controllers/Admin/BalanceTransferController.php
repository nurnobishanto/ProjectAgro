<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BalanceTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class BalanceTransferController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $balance_transfers = BalanceTransfer::orderBy('id','DESC')->get();
        return view('admin.balance_transfers.index',compact('balance_transfers'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $balance_transfers = BalanceTransfer::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.balance_transfers.trashed',compact('balance_transfers'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.balance_transfers.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
        ]);
        BalanceTransfer::create([
            'unique_id' =>$request->unique_id,
            'date' =>$request->date,
            'from_account_id' =>$request->from_account_id,
            'to_account_id' =>$request->to_account_id,
            'amount' =>$request->amount,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.balance_transfer').__('global.created'));
        return redirect()->route('admin.balance-transfers.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::find($id);
        return view('admin.balance_transfers.show',compact('balance_transfer'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::find($id);
        return view('admin.balance_transfers.edit',compact(['balance_transfer']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::find($id);
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
        ]);
        $balance_transfer->unique_id = $request->unique_id;
        $balance_transfer->date = $request->date;
        $balance_transfer->from_account_id = $request->from_account_id;
        $balance_transfer->to_account_id = $request->to_account_id;
        $balance_transfer->amount = $request->amount;
        $balance_transfer->note = $request->note;
        $balance_transfer->status = 'pending';
        $balance_transfer->updated_by = auth()->user()->id;
        $balance_transfer->update();
        toastr()->success($balance_transfer->name.__('global.updated_success'),__('global.balance_transfer').__('global.updated'));
        return redirect()->route('admin.balance-transfers.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::find($id);
        $balance_transfer->delete();
        toastr()->warning($balance_transfer->name.__('global.deleted_success'),__('global.balance_transfer').__('global.deleted'));
        return redirect()->route('admin.balance-transfers.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::withTrashed()->find($id);
        $balance_transfer->deleted_at = null;
        $balance_transfer->update();
        toastr()->success($balance_transfer->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.balance-transfers.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $balance_transfer = BalanceTransfer::withTrashed()->find($id);
        $balance_transfer->forceDelete();
        toastr()->error(__('global.balance_transfer').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.balance-transfers.trashed');
    }

    public function approve ($id){
        $bt = BalanceTransfer::find($id);

        if ($bt->status != 'success'){
            $fromAccount = $bt->fromAccount;
            $toAccount = $bt->toAccount;

            $fromAccount->current_balance = $fromAccount->current_balance - $bt->amount;
            $fromAccount->update();

            $toAccount->current_balance = $toAccount->current_balance + $bt->amount;
            $toAccount->update();

            $bt->status = 'success';
            $bt->update();
        }
        toastr()->success($bt->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.balance-transfers.index');
    }

}
