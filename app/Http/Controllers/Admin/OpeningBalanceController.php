<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OpeningBalance;
use App\Models\CattleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class OpeningBalanceController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $opening_balances = OpeningBalance::orderBy('id','DESC')->get();
        return view('admin.opening_balances.index',compact('opening_balances'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $opening_balances = OpeningBalance::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.opening_balances.trashed',compact('opening_balances'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.opening_balances.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
         OpeningBalance::create([
            'unique_id' =>$request->unique_id,
            'date' =>$request->date,
            'account_id' =>$request->account_id,
            'amount' =>$request->amount,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.opening_balance').__('global.created'));
        return redirect()->route('admin.opening-balances.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::find($id);
        return view('admin.opening_balances.show',compact('opening_balance'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::find($id);
        return view('admin.opening_balances.edit',compact(['opening_balance']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::find($id);
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $opening_balance->unique_id = $request->unique_id;
        $opening_balance->date = $request->date;
        $opening_balance->account_id = $request->account_id;
        $opening_balance->amount = $request->amount;
        $opening_balance->note = $request->note;
        $opening_balance->status = 'pending';
        $opening_balance->updated_by = auth()->user()->id;
        $opening_balance->update();
        toastr()->success($opening_balance->name.__('global.updated_success'),__('global.opening_balance').__('global.updated'));
        return redirect()->route('admin.opening-balances.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::find($id);
        $opening_balance->delete();
        toastr()->warning($opening_balance->name.__('global.deleted_success'),__('global.opening_balance').__('global.deleted'));
        return redirect()->route('admin.opening-balances.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::withTrashed()->find($id);
        $opening_balance->deleted_at = null;
        $opening_balance->update();
        toastr()->success($opening_balance->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.opening-balances.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $opening_balance = OpeningBalance::withTrashed()->find($id);
        $opening_balance->forceDelete();
        toastr()->error(__('global.opening_balance').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.opening-balances.trashed');
    }

    public function approve ($id){
        $ob = OpeningBalance::find($id);

        if ($ob->status != 'success'){
            $account = $ob->account;
            $account->current_balance = $account->current_balance + $ob->amount;
            $account->update();

            $ob->status = 'success';
            $ob->update();
        }
        toastr()->success($ob->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.opening-balances.index');
    }

}
