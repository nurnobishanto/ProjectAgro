<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlaughterCustomerReceive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SlaughterCustomerReceiveController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $slaughter_customer_receives = SlaughterCustomerReceive::orderBy('id','DESC')->get();
        return view('admin.slaughter_customer_receives.index',compact('slaughter_customer_receives'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $slaughter_customer_receives = SlaughterCustomerReceive::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.slaughter_customer_receives.trashed',compact('slaughter_customer_receives'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.slaughter_customer_receives.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'slaughter_customer_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        SlaughterCustomerReceive::create([
            'unique_id' =>$request->unique_id,
            'date' =>$request->date,
            'slaughter_customer_id' =>$request->slaughter_customer_id,
            'account_id' =>$request->account_id,
            'amount' =>$request->amount,
            'type' =>$request->type,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success(__('global.created_success'),__('global.slaughter_customer_receive').__('global.created'));
        return redirect()->route('admin.slaughter_customer-receives.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::find($id);
        return view('admin.slaughter_customer_receives.show',compact('slaughter_customer_receive'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::find($id);
        return view('admin.slaughter_customer_receives.edit',compact(['slaughter_customer_receive']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::find($id);
        $request->validate([
            'unique_id' => 'required',
            'date' => 'required',
            'type' => 'required',
            'slaughter_customer_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
        ]);
        $slaughter_customer_receive->unique_id = $request->unique_id;
        $slaughter_customer_receive->date = $request->date;
        $slaughter_customer_receive->account_id = $request->account_id;
        $slaughter_customer_receive->slaughter_customer_id = $request->slaughter_customer_id;
        $slaughter_customer_receive->type = $request->type;
        $slaughter_customer_receive->amount = $request->amount;
        $slaughter_customer_receive->note = $request->note;
        $slaughter_customer_receive->status = 'pending';
        $slaughter_customer_receive->updated_by = auth()->user()->id;
        $slaughter_customer_receive->update();
        toastr()->success($slaughter_customer_receive->name.__('global.updated_success'),__('global.slaughter_customer_receive').__('global.updated'));
        return redirect()->route('admin.slaughter_customer-receives.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::find($id);
        $slaughter_customer_receive->delete();
        toastr()->warning($slaughter_customer_receive->name.__('global.deleted_success'),__('global.slaughter_customer_receive').__('global.deleted'));
        return redirect()->route('admin.slaughter_customer-receives.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::withTrashed()->find($id);
        $slaughter_customer_receive->deleted_at = null;
        $slaughter_customer_receive->update();
        toastr()->success($slaughter_customer_receive->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.slaughter_customer-receives.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $slaughter_customer_receive = SlaughterCustomerReceive::withTrashed()->find($id);
        $slaughter_customer_receive->forceDelete();
        toastr()->error(__('global.slaughter_customer_receive').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.slaughter_customer-receives.trashed');
    }

    public function approve ($id){
        $scr = SlaughterCustomerReceive::find($id);

        if ($scr->status != 'success'){
            $account = $scr->account;
            $slaughter_customer = $scr->slaughter_customer;

            if ($scr->type == 'receive'){
                $account->current_balance = $account->current_balance + $scr->amount;
                $account->update();

                $slaughter_customer->balance = $slaughter_customer->balance - $scr->amount;
                $slaughter_customer->update();
            }else{
                $account->current_balance = $account->current_balance - $scr->amount;
                $account->update();

                $slaughter_customer->balance = $slaughter_customer->balance + $scr->amount;
                $slaughter_customer->update();
            }
            $scr->status = 'success';
            $scr->update();
        }
        toastr()->success($scr->unique_id.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.slaughter_customer-receives.index');
    }

}

