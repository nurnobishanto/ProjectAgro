<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class AccountController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $accounts = Account::orderBy('id','DESC')->get();
        return view('admin.accounts.index',compact('accounts'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $accounts = Account::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.accounts.trashed',compact('accounts'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.accounts.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'admin_id' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'previous_balance' => 'required',
            'status' => 'required',
        ]);

        $account = Account::create([
            'admin_id' =>$request->admin_id,
            'bank_name' =>$request->bank_name,
            'account_name' =>$request->account_name,
            'account_no' =>$request->account_no,
            'account_type' =>$request->account_type,
            'previous_balance' =>$request->previous_balance??0,
            'current_balance' =>$request->previous_balance??0,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($account->name.__('global.created_success'),__('global.account').__('global.created'));
        return redirect()->route('admin.accounts.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $account = Account::find($id);
        return view('admin.accounts.show',compact('account'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $account = Account::find($id);
        return view('admin.accounts.edit',compact(['account']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $account = Account::find($id);
        $request->validate([
            'admin_id' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'status' => 'required',
        ]);
        $account->admin_id = $request->admin_id;
        $account->bank_name = $request->bank_name;
        $account->account_name = $request->account_name;
        $account->account_no = $request->account_no;
        $account->account_type = $request->account_type;
        $account->status = $request->status;
        $account->updated_by = auth()->user()->id;
        $account->update();
        toastr()->success($account->name.__('global.updated_success'),__('global.account').__('global.updated'));
        return redirect()->route('admin.accounts.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $account = Account::find($id);
        $account->delete();
        toastr()->success($account->name.__('global.deleted_success'),__('global.account').__('global.deleted'));
        return redirect()->route('admin.accounts.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $account = Account::withTrashed()->find($id);
        $account->deleted_at = null;
        $account->update();
        toastr()->success($account->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.accounts.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $account = Account::withTrashed()->find($id);
        $account->forceDelete();
        toastr()->success(__('global.account').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.accounts.trashed');
    }

}
