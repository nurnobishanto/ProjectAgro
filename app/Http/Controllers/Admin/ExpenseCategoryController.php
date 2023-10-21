<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        App::setLocale(session('locale'));
        $expense_categories = ExpenseCategory::orderBy('id','DESC')->get();
        return view('admin.expense_categories.index',compact('expense_categories'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $expense_categories = ExpenseCategory::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.expense_categories.trashed',compact('expense_categories'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.expense_categories.create');
    }

    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required|unique:expense_categories',
            'status' => 'required',
        ]);
        $expense_category = ExpenseCategory::create([
            'name' =>$request->name,
            'status' =>$request->status,
            'created_by' =>auth()->user()->id,
            'updated_by' =>auth()->user()->id,
        ]);
        toastr()->success($expense_category->name.__('global.created_success'),__('global.expense_category').__('global.created'));
        return redirect()->route('admin.expense-categories.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::find($id);

        return view('admin.expense_categories.show',compact('expense_category'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::find($id);
        return view('admin.expense_categories.edit',compact(['expense_category']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::find($id);
        $request->validate([
            'name' => 'required|unique:expense_categories',
            'status' => 'required',
        ]);
        $expense_category->name = $request->name;
        $expense_category->status = $request->status;
        $expense_category->updated_by = auth()->user()->id;
        $expense_category->update();
        toastr()->success($expense_category->name.__('global.updated_success'),__('global.expense_category').__('global.updated'));
        return redirect()->route('admin.expense-categories.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::find($id);
        $expense_category->delete();
        toastr()->warning($expense_category->name.__('global.deleted_success'),__('global.expense_category').__('global.deleted'));
        return redirect()->route('admin.expense-categories.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::withTrashed()->find($id);
        $expense_category->deleted_at = null;
        $expense_category->update();
        toastr()->success($expense_category->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.expense-categories.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $expense_category = ExpenseCategory::withTrashed()->find($id);
        $expense_category->forceDelete();
        toastr()->error(__('global.expense_category').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.expense-categories.trashed');
    }

}
