<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class ExpenseController extends Controller
{

    public function approve($id){
        $expense = Expense::find($id);

        $account =  Account::find($expense->account_id);
        $current_balance = $account->current_balance;
        $account->current_balance = $current_balance - $expense->amount;
        $account->update();

        $expense->status = 'success';
        $expense->update();
        toastr()->success($expense->date.__('global.approved_success'),__('global.approved'));
        return redirect()->route('admin.expenses.index');

    }
    public function index()
    {
        App::setLocale(session('locale'));
        $expenses = Expense::orderBy('id','desc')->get();
        return view('admin.expenses.index',compact('expenses'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $expenses = Expense::orderBy('id','desc')->get();
        return view('admin.expenses.trashed',compact('expenses'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $data = array();
        $data['accounts'] = Account::where('admin_id',auth()->user()->id)->where('status','active')->get();
        $data['expense_categories'] = ExpenseCategory::where('status','active')->get();
        return view('admin.expenses.create',$data);
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'date' => 'required',
            'account_id' => 'required',
            'expense_category_id' => 'required',
            'amount' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('expense-photo');
        }
        $expense = Expense::create([
            'date' =>$request->date,
            'account_id' =>$request->account_id,
            'expense_category_id' =>$request->expense_category_id,
            'amount' =>$request->amount,
            'note' =>$request->note,
            'status' => 'pending',
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
            'photo' =>$imagePath,
        ]);

        toastr()->success($expense->name.__('global.created_success'),__('global.expense').__('global.created'));
        return redirect()->route('admin.expenses.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $expense = Expense::find($id);
        return view('admin.expenses.show',compact('expense'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $data = array();
        $data['accounts'] = Account::where('admin_id',auth()->user()->id)->where('status','active')->get();
        $data['expense_categories'] = ExpenseCategory::where('status','active')->get();
        $data['expense'] = Expense::find($id);
        return view('admin.expenses.edit',$data);
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $expense = Expense::find($id);
        $request->validate([
            'date' => 'required',
            'account_id' => 'required',
            'expense_category_id' => 'required',
            'amount' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $expense->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('expense-photo');
            $old_image_path = "uploads/".$expense->photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $preAmount = $expense->amount;
        $expense->date = $request->date;
        $expense->account_id = $request->account_id;
        $expense->expense_category_id = $request->expense_category_id;
        $expense->amount = $request->amount;
        $expense->note = $request->note;
        $expense->photo = $imagePath;
        $expense->update();

        toastr()->success($expense->name.__('global.updated_success'),__('global.expense').__('global.updated'));
        return redirect()->route('admin.expenses.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $expense = Expense::find($id);
        $expense->delete();
        toastr()->success($expense->name.__('global.deleted_success'),__('global.expense').__('global.deleted'));
        return redirect()->route('admin.expenses.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $expense = Expense::withTrashed()->find($id);

        $expense->deleted_at = null;
        $expense->update();
        toastr()->success($expense->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.expenses.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $expense = Expense::withTrashed()->find($id);
        $old_image_path = "uploads/".$expense->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $expense->forceDelete();
        toastr()->success(__('global.expense').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.expenses.trashed');
    }

}
