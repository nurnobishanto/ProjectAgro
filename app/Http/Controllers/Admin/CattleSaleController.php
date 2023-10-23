<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Cattle;
use App\Models\CattleSale;
use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class CattleSaleController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $cattle_sales = CattleSale::orderBy('id','DESC')->get();
        if ($request->date){
            $cattle_sales = $cattle_sales->where('date',$request->date);
        }
        if ($request->status){
            $cattle_sales = $cattle_sales->where('status',$request->status);
        }
        return view('admin.cattle_sales.index',compact('cattle_sales'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $cattle_sales = CattleSale::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.cattle_sales.trashed',compact('cattle_sales'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.cattle-sales.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $cattle = Cattle::where('id',$request->tag_id)->where('status','active')->first();
        $amount = 500;
        return view('admin.cattle_sales.create',compact(['cattle','amount']));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'cattle_id' => 'required|unique:cattle_sales',
            'amount' => 'required',
            'account_id' => 'required',
            'party_id' => 'required',
        ]);
        CattleSale::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'cattle_id' => $request->cattle_id,
            'party_id' => $request->party_id,
            'account_id' => $request->account_id,
            'amount' => $request->amount??0,
            'paid' => $request->paid??0,
            'due' => $request->due??0,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.cattle_sale').__('global.created'));
        return redirect()->route('admin.cattle-sales.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_sale = CattleSale::find($id);
        $data = array();
        $data['cattle_sale'] = $cattle_sale;
        $data['cattle'] = $cattle_sale->cattle;
        $data['amount'] = $cattle_sale->amount;
        return view('admin.cattle_sales.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_sale = CattleSale::find($id);
        $data = array();
        $data['cattle_sale'] = $cattle_sale;
        $data['cattle'] = $cattle_sale->cattle;
        $data['amount'] = $cattle_sale->amount;
        return view('admin.cattle_sales.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'account_id' => 'required',
            'party_id' => 'required',
        ]);

        $cattle_sale = CattleSale::find($id);
        $cattle_sale->unique_id = $request->unique_id;
        $cattle_sale->date = $request->date;
        $cattle_sale->party_id = $request->party_id;
        $cattle_sale->account_id = $request->account_id;
        $cattle_sale->amount = $request->amount;
        $cattle_sale->paid = $request->paid;
        $cattle_sale->due = $request->due;
        $cattle_sale->note = $request->note;
        $cattle_sale->updated_by = auth()->user()->id;
        $cattle_sale->update();

        toastr()->success(__('global.updated_success'),__('global.cattle_sale').__('global.updated'));
        return redirect()->route('admin.cattle-sales.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $cattle_sale = CattleSale::find($id);
        $cattle_sale->delete();

        toastr()->warning($cattle_sale->name.__('global.deleted_success'),__('global.cattle_sale').__('global.deleted'));
        return redirect()->route('admin.cattle-sales.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $cattle_sale = CattleSale::withTrashed()->find($id);
        $cattle_sale->deleted_at = null;
        $cattle_sale->update();
        toastr()->success($cattle_sale->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.cattle-sales.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $cattle_sale = CattleSale::withTrashed()->find($id);
        $cattle_sale->forceDelete();
        toastr()->error(__('global.cattle_sale').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.cattle-sales.trashed');
    }
    public function approve ($id){
        $cattle_sale = CattleSale::find($id);

        if ($cattle_sale->status != 'success'){
            $cattle = $cattle_sale->cattle;
            $cattle->status = 'sold';
            $cattle->update();

            $party = $cattle_sale->party;
            $party->current_balance = $party->current_balance + $cattle_sale->due;
            $party->update();

            $account = $cattle_sale->account;
            $account->current_balance = $account->current_balance + $cattle_sale->paid;
            $account->update();

            $cattle_sale->status = 'success';
            $cattle_sale->update();
        }
        toastr()->success($cattle_sale->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.cattle-sales.index');
    }

}
