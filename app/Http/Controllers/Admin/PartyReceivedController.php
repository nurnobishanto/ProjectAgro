<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartyReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class PartyReceivedController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $party_receives = PartyReceive::orderBy('id','DESC')->get();
        return view('admin.party_receives.index',compact('party_receives'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $party_receives = PartyReceive::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.party_receives.trashed',compact('party_receives'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.party_receives.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'party_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        PartyReceive::create([
            'unique_id' =>$request->unique_id,
            'date' =>$request->date,
            'party_id' =>$request->party_id,
            'account_id' =>$request->account_id,
            'amount' =>$request->amount,
            'type' =>$request->type,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.party_receive').__('global.created'));
        return redirect()->route('admin.party-receives.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::find($id);
        return view('admin.party_receives.show',compact('party_receive'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::find($id);
        return view('admin.party_receives.edit',compact(['party_receive']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::find($id);
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'party_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $party_receive->unique_id = $request->unique_id;
        $party_receive->date = $request->date;
        $party_receive->account_id = $request->account_id;
        $party_receive->party_id = $request->party_id;
        $party_receive->type = $request->type;
        $party_receive->amount = $request->amount;
        $party_receive->note = $request->note;
        $party_receive->status = 'pending';
        $party_receive->updated_by = auth()->user()->id;
        $party_receive->update();
        toastr()->success($party_receive->name.__('global.updated_success'),__('global.party_receive').__('global.updated'));
        return redirect()->route('admin.party-receives.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::find($id);
        $party_receive->delete();
        toastr()->warning($party_receive->name.__('global.deleted_success'),__('global.party_receive').__('global.deleted'));
        return redirect()->route('admin.party-receives.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::withTrashed()->find($id);
        $party_receive->deleted_at = null;
        $party_receive->update();
        toastr()->success($party_receive->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.party-receives.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $party_receive = PartyReceive::withTrashed()->find($id);
        $party_receive->forceDelete();
        toastr()->error(__('global.party_receive').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.party-receives.trashed');
    }

    public function approve ($id){
        $pr = PartyReceive::find($id);

        if ($pr->status != 'success'){
            $account = $pr->account;
            $party = $pr->party;

            if ($pr->type == 'receive'){
                $account->current_balance = $account->current_balance + $pr->amount;
                $account->update();

                $party->current_balance = $party->current_balance - $pr->amount;
                $party->update();
            }else{
                $account->current_balance = $account->current_balance - $pr->amount;
                $account->update();

                $party->current_balance = $party->current_balance + $pr->amount;
                $party->update();
            }



            $pr->status = 'success';
            $pr->update();
        }
        toastr()->success($pr->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.party-receives.index');
    }

}
