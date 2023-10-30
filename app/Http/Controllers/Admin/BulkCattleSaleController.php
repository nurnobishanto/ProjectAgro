<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\BulkCattleSale;
use App\Models\CattleType;
use App\Models\Farm;
use App\Models\PartyReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;


class BulkCattleSaleController extends Controller
{
    public function index(Request $request)
    {
        App::setLocale(session('locale'));
        $bulk_cattle_sales = BulkCattleSale::orderBy('id','DESC')->get();
        if ($request->date){
            $bulk_cattle_sales = $bulk_cattle_sales->where('date',$request->date);
        }
        if ($request->status){
            $bulk_cattle_sales = $bulk_cattle_sales->where('status',$request->status);
        }
        return view('admin.bulk_cattle_sales.index',compact('bulk_cattle_sales'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $bulk_cattle_sales = BulkCattleSale::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.bulk_cattle_sales.trashed',compact('bulk_cattle_sales'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farm_id' => 'required',
            'cattle_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.bulk-cattle-sales.index')->withErrors($validator)->withInput();
        }
        App::setLocale(session('locale'));
        $farm = Farm::find($request->farm_id);
        $type = CattleType::find($request->cattle_type_id);
        $cattles = Cattle::where('farm_id',$request->farm_id)->where('cattle_type_id',$request->cattle_type_id)->where('status','active')->get();

        return view('admin.bulk_cattle_sales.create',compact(['cattles','farm','type']));
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'account_id' => 'required',
            'party_id' => 'required',
            'cattle_type_id' => 'required',
            'farm_id' => 'required',
            'cattles' => 'required',
        ]);
        $bul_sale = BulkCattleSale::create([
            'unique_id' => $request->unique_id,
            'date' => $request->date,
            'party_id' => $request->party_id,
            'account_id' => $request->account_id,
            'cattle_type_id' => $request->cattle_type_id,
            'farm_id' => $request->farm_id,
            'amount' => $request->amount??0,
            'paid' => $request->paid??0,
            'due' => $request->due??0,
            'expense' => $request->expense??0,
            'note' => $request->note,
            'status' => 'pending',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);
        $bul_sale->cattles()->sync($request->cattles);

        toastr()->success(__('global.created_success'),__('global.bulk_cattle_sale').__('global.created'));
        return redirect()->route('admin.bulk-cattle-sales.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $bulk_cattle_sale = BulkCattleSale::find($id);
        $data = array();
        $data['bulk_cattle_sale'] = $bulk_cattle_sale;
        return view('admin.bulk_cattle_sales.show',$data);
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $bulk_cattle_sale = BulkCattleSale::find($id);
        $data = array();
        $data['bulk_cattle_sale'] = $bulk_cattle_sale;
        $data['cattles'] = Cattle::where('farm_id',$bulk_cattle_sale->farm_id)->where('cattle_type_id',$bulk_cattle_sale->cattle_type_id)->get();
        return view('admin.bulk_cattle_sales.edit',$data);
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
            'cattles' => 'required',
        ]);
        $bulk_cattle_sale = BulkCattleSale::find($id);
        $bulk_cattle_sale->unique_id = $request->unique_id;
        $bulk_cattle_sale->date = $request->date;
        $bulk_cattle_sale->party_id = $request->party_id;
        $bulk_cattle_sale->account_id = $request->account_id;
        $bulk_cattle_sale->amount = $request->amount;
        $bulk_cattle_sale->paid = $request->paid;
        $bulk_cattle_sale->due = $request->due;
        $bulk_cattle_sale->expense = $request->expense;
        $bulk_cattle_sale->note = $request->note;
        $bulk_cattle_sale->updated_by = auth()->user()->id;
        $bulk_cattle_sale->update();
        $bulk_cattle_sale->cattles()->sync($request->cattles);
        toastr()->success(__('global.updated_success'),__('global.bulk_cattle_sale').__('global.updated'));
        return redirect()->route('admin.bulk-cattle-sales.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $bulk_cattle_sale = BulkCattleSale::find($id);
        $bulk_cattle_sale->delete();

        toastr()->warning($bulk_cattle_sale->name.__('global.deleted_success'),__('global.bulk_cattle_sale').__('global.deleted'));
        return redirect()->route('admin.bulk-cattle-sales.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $bulk_cattle_sale = BulkCattleSale::withTrashed()->find($id);
        $bulk_cattle_sale->deleted_at = null;
        $bulk_cattle_sale->update();
        toastr()->success($bulk_cattle_sale->date.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.bulk-cattle-sales.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $bulk_cattle_sale = BulkCattleSale::withTrashed()->find($id);
        $bulk_cattle_sale->cattles()->detach();
        $bulk_cattle_sale->forceDelete();
        toastr()->error(__('global.bulk_cattle_sale').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.bulk-cattle-sales.trashed');
    }
    public function approve ($id){
        $bulk_cattle_sale = BulkCattleSale::find($id);

        if ($bulk_cattle_sale->status != 'success'){
            foreach ($bulk_cattle_sale->cattles as $cattle){
                $cattle->status = 'sold';
                $cattle->update();
            }

            $party = $bulk_cattle_sale->party;
            $party->current_balance = $party->current_balance + $bulk_cattle_sale->due;
            $party->update();

            $account = $bulk_cattle_sale->account;
            $account->current_balance = $account->current_balance + ($bulk_cattle_sale->paid - $cattle->expense);
            $account->update();

            PartyReceive::create([
                'unique_id' => generateInvoiceId('PR',\App\Models\PartyReceive::class,'unique_id'),
                'date' =>$bulk_cattle_sale->date,
                'party_id' =>$bulk_cattle_sale->party_id,
                'account_id' =>$bulk_cattle_sale->account_id,
                'amount' =>$bulk_cattle_sale->amount,
                'type' =>'receive',
                'note' =>'Received at Sale for '.$bulk_cattle_sale->unique_id,
                'status' => 'success',
                'created_by' =>auth()->user()->id,
                'updated_by' =>auth()->user()->id,
            ]);

            $bulk_cattle_sale->status = 'success';
            $bulk_cattle_sale->update();
        }
        toastr()->success($bulk_cattle_sale->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.bulk-cattle-sales.index');
    }

}
